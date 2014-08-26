
# Copyright (C) 2014 - Oscar Campos <oscar.campos@member.fsf.org>
# This program is Free Software see LICENSE file for details

"""Anaconda.PHP php lint wrapper
"""

import os
import subprocess

from helpers import create_subprocess

PIPE = subprocess.PIPE


class PHPLinter(object):
    """PHPLinter class for Anaconda.PHP
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

        args = ['php', '-l']
        args.append(self.filename)
        proc = create_subprocess(args, stdout=PIPE, cwd=os.getcwd())
        self.output, self.error = proc.communicate()

    def parse_errors(self):
        """Parse the output given by php -l
        """

        if self.error is not None:
            raise RuntimeError(self.error)

        errors = {'E': [], 'W': [], 'V': []}
        if not 'No syntax errors detected' in self.output:
            split_lines = self.output.splitlines()
            for i in range(len(split_lines) - 1):
                line_data = split_lines[i].split(':')[1].split(' on')
                errors['E'].append({
                    'line': int(line_data[1].split(' line ')[1]),
                    'offset': 0,
                    'code': 0,
                    'message': '[php -l] {0}'.format(line_data[0].strip())
                })

        return errors
