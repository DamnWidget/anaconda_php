
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

    def __init__(self, callback, uid, vid, filename, settings):
        self.vid = vid
        self.settings = settings
        self.filename = filename
        super(PHPCPD, self).__init__(callback, uid)

    def run(self):
        """Run the command
        """

        try:
            self.callback({
                'success': True,
                'output': self.php_copy_and_paste_detector(),
                'uid': self.uid,
                'vid': self.vid
            })
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
            self.settings.get('phpcpd_min_lines', 5),
            self.settings.get('phpcpd_min_tokens', 70)
        ] + self.settings.get('phpcpd_additional_arguments', [])

        proc = spawn(args, stdout=PIPE, stderr=PIPE, cwd=os.getcwd())
        output, error = proc.communicate()
        if sys.version_info >= (3, 0):
            output = output.decode('utf8')

        return output
