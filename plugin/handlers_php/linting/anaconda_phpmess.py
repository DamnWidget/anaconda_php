
# Copyright (C) 2014 - Oscar Campos <oscar.campos@member.fsf.org>
# This program is Free Software see LICENSE file for details

"""Anaconda.PHP phpmess lint wrapper
"""

import os
import sys
import subprocess

from process import spawn


PIPE = subprocess.PIPE


class PHPMess(object):
    """PHPMessDetector class for Anaconda.PHP
    """

    def __init__(self, filename, settings):
        self.filename = filename
        self.settings = settings
        self.output = None
        self.error = None

        self.execute()

    def execute(self):
        """Execute the linting process
        """

        rules = ','.join(self.settings.get(
            'phpmd_ruleset', ['unusedcode', 'naming', 'codesize'])
        )
        phpmd = os.path.join(os.path.dirname(__file__), 'phpmd/src/bin/phpmd')
        args = [
            'php', '-d date.timezone=UTC', phpmd, self.filename, 'text', rules
        ]

        for arg in self.settings.get('phpmd_additional_arguments', []):
            args.append(arg)

        args.append(self.filename)
        proc = spawn(args, stdout=PIPE, stderr=PIPE, cwd=os.getcwd())
        self.output, self.error = proc.communicate()
        if sys.version_info >= (3, 0):
            self.output = self.output.decode('utf8')

    def parse_errors(self):
        """Parse the JSON output given by phpcs --report=json
        """

        # phpmd errors as always trated as violations
        errors = {'E': [], 'W': [], 'V': []}

        for error_line in self.output.splitlines():
            if error_line != '':
                message = error_line.split('/t')[1]
                line = error_line.split('/t')[0].split(':')[1]
                errors['V'].append({
                    'line': line,
                    'offset': 0,
                    'code': 0,
                    'message': '[V] phpm: {0}'.format(message)
                })

        return errors
