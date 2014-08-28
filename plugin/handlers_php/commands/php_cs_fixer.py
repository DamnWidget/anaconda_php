
# Copyright (C) 2014 - Oscar Campos <oscar.campos@member.fsf.org>
# This program is Free Software see LICENSE file for details

import os
import logging
import traceback
import subprocess

from commands.base import Command

from process import spawn

PIPE = subprocess.PIPE


class PHPCSFixer(Command):
    """Run phpcs linter and return back results
    """

    def __init__(self, callback, uid, vid, filename, settings):
        self.vid = vid
        self.settings = settings
        self.filename = filename
        super(PHPCSFixer, self).__init__(callback, uid)

    def run(self):
        """Run the command
        """

        try:
            self.callback({
                'success': True,
                'output': self.phpcs_fixer(),
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

    def phpcs_fixer(self):
        """Run the php-cs-fixer command in a file
        """

        phpcs_fixer = os.path.join(
            os.path.dirname(__file__), '../linting/phpcs_fixer/php-cs-fixer')
        args = [
            'php', '-n', phpcs_fixer, 'fix', self.filename, '--level=all',
            '-{}'.format(self.settings.get('phpcs_fixer_verbosity_level'), 'v')
        ] + self.settings.get('phpcs_fixer_additional_arguments', [])

        proc = spawn(args, stdout=PIPE, stderr=PIPE, cwd=os.getcwd())
        output, error = proc.communicate()
        logging.info(output)
        logging.info(error)

        if error != '':
            raise RuntimeError(error)

        return output
