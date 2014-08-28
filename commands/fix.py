
# Copyright (C) 2014 - Oscar Campos <oscar.campos@member.fsf.org>
# This program is Free Software see LICENSE file for details

import logging
import traceback

import sublime
import sublime_plugin

from ..anaconda_lib.helpers import get_settings
from anaconda.anaconda_lib.helpers import is_code
from anaconda.anaconda_lib.progress_bar import ProgressBar
from ..anaconda_lib.anaconda_plugin import Worker, Callback


class AnacondaPhpFix(sublime_plugin.TextCommand):
    """Execute php-cs-fixer command
    """

    output = None

    def run(self, edit):
        if self.output is None:
            settings = {
                'phpcs_fixer_verbosity_level': get_settings(
                    self.view, 'phpcs_fixer_verbosity_level', 'v'),
                'phpcs_fixer_additional_arguments': get_settings(
                    self.view, 'phpcs_fixer_additional_arguments', ['-n'])
            }
            try:
                messages = {
                    'start': 'Autoformatting please wait... ',
                    'end': 'Autoformatting done!',
                    'fail': 'Autoformatting failed, buffer not changed.',
                    'timeout': 'Autoformatting failed, buffer not changed.'
                }
                self.pbar = ProgressBar(messages)
                self.pbar.start()
                self.view.set_read_only(True)

                data = {
                    'vid': self.view.id(),
                    'filename': self.view.file_name(),
                    'method': 'phpcs_fixer',
                    'settings': settings,
                    'handler': 'php_cs_fixer'
                }
                timeout = get_settings(self.view, 'phpcs_fixer_timeout', 1)

                callback = Callback(timeout=timeout)
                callback.on(success=self.prepare_data)
                callback.on(error=self.on_failure)
                callback.on(timeout=self.on_failure)

                Worker().execute(callback, **data)
            except:
                logging.error(traceback.format_exc())
        else:
            self.print_output(edit)

    def is_enabled(self):
        """Determine if this command is enabled or not
        """

        return is_code(self.view, lang='php', ignore_comments=True)

    def on_failure(self, *args, **kwargs):
        """Called when failures or timeout
        """

        self.pbar.terminate(status=self.pbar.Status.FAILURE)
        self.view.set_read_only(False)

    def prepare_data(self, data):
        """Prepare the returned data
        """

        self.pbar.terminate()
        self.view.set_read_only(False)
        if data['success']:
            self.output = data['output']
            if self.output is None or self.output == '':
                self._show_status()
            else:
                sublime.active_window().run_command(self.name())

    def print_output(self, edit):
        """Print the php-cs-fixer command output and reload the buffer
        """

        output_panel = self.view.window().create_output_panel(
            'anaconda_php_fixer_output'
        )

        output_panel.set_read_only(False)
        region = sublime.Region(0, output_panel.size())
        output_panel.erase(edit, region)
        output_panel.insert(edit, 0, self.output)
        self.output = None
        output_panel.set_read_only(True)
        output_panel.show(0)
        self.view.window().run_command(
            'show_panel', {'panel': 'output.anaconda_php_fixer_output'}
        )
