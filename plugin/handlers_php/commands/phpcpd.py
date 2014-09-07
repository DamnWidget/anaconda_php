
# Copyright (C) 2014 - Oscar Campos <oscar.campos@member.fsf.org>
# This program is Free Software see LICENSE file for details

import os
import sys
import logging
import traceback
import subprocess

from commands.base import Command

from process import spawn

PIPE = subprocess.PIPE


class PHPCPD(Command):
    """Run phpcs linter and return back results
    """

    def __init__(self, callback, uid, vid, filename, settings, lint=False):
        self.vid = vid
        self.lint = lint
        self.settings = settings
        self.filename = filename
        super(PHPCPD, self).__init__(callback, uid)

    def run(self):
        """Run the command
        """

        try:
            output = self.php_copy_and_paste_detector()
            callback_data = {
                'success': True,
                'uid': self.uid,
                'vid': self.vid
            }
            callback_data['output' if not self.lint else 'errors'] = output
            self.callback(callback_data)
        except Exception as error:
            logging.error(error)
            logging.debug(traceback.format_exc())
            print(traceback.format_exc())
            self.callback({
                'success': False,
                'error': error,
                'uid': self.uid,
                'vid': self.vid
            })

    def php_copy_and_paste_detector(self):
        """Run the phpcpd command in a file or directory
        """

        phpcpd = os.path.join(
            os.path.dirname(__file__), '../linting/phpcpd/phpcpd.phar')
        args = ['php', '-n', '-d', 'memory_limit=-1', phpcpd, self.filename]
        configured_verbosity = self.settings.get('phpcpd_verbosity_level', 0)
        if configured_verbosity > 0:
            verbosity_lvl = '-{}'.format('v' * configured_verbosity)
            args.append(verbosity_lvl)

        args += [
            '--min-lines', str(self.settings.get('phpcpd_min_lines', 5)),
            '--min-tokens', str(self.settings.get('phpcpd_min_tokens', 70))
        ] + self.settings.get('phpcpd_additional_arguments', [])

        proc = spawn(args, stdout=PIPE, stderr=PIPE, cwd=os.getcwd())
        output, error = proc.communicate()
        if sys.version_info >= (3, 0):
            output = output.decode('utf8')

        return output if not self.lint else self.to_lint_fmt(output)

    def to_lint_fmt(self, data):
        """Prepare the output to linter format
        """

        # treated as violations
        errors = {'E': [], 'W': [], 'V': []}

        splited_data = data.splitlines()
        for i in range(len(splited_data)):
            error_line = splited_data[i]
            if '  -' in error_line:
                from_line, to_line = self._from_line_to_line(error_line)
                from_cp_line, to_cp_line = self._from_line_to_line(
                    splited_data[i + 1])

                message = (
                    'copy & paste code block detected: code from lines {0} '
                    'to {1} is duplicated in {2} to {3}'.format(
                        from_line, to_line, from_cp_line, to_cp_line
                    )
                )
                line = from_line
                errors['V'].append({
                    'line': line,
                    'offset': 0,
                    'code': 0,
                    'message': '[V] phpcpd: {0}'.format(message)
                })

        return errors

    def _from_line_to_line(self, error_line):
        """Parse the error line and give back the lines range in a tuple
        """

        return error_line.rsplit('.php:', 1)[1].split('-')
