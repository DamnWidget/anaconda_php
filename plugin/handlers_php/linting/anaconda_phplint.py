
# Copyright (C) 2014 - Oscar Campos <oscar.campos@member.fsf.org>
# This program is Free Software see LICENSE file for details

"""Anaconda.PHP php lint wrapper
"""

import os
import sys
import subprocess

from process import spawn

PIPE = subprocess.PIPE


class PHPLint(object):
    """PHPLint class for Anaconda.PHP
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

        args = ['php', '-l', '-n', '-d dislay_errors=On -d log_errors=Off']
        args.append(self.filename)
        proc = spawn(args, stdout=PIPE, stderr=PIPE, cwd=os.getcwd())
        self.output, self.error = proc.communicate()
        if sys.version_info >= (3, 0):
            self.output = self.output.decode('utf8')

    def parse_errors(self):
        """Parse the output given by php -l
        """

        errors = {'E': [], 'W': [], 'V': []}
        if not 'No syntax errors detected' in self.output:
            split_lines = str(self.output.splitlines())
            for i in range(len(split_lines) - 1):
                if not split_lines[i]:
                    continue

                line_data = split_lines[i].split(':')[1].split(' on')
                errors['E'].append({
                    'line': int(line_data[1].split(' line ')[1]),
                    'offset': 0,
                    'code': 0,
                    'message': '[php -l] {0}'.format(line_data[0].strip())
                })

        return errors
