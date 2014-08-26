
# Copyright (C) 2014 - Oscar Campos <oscar.campos@member.fsf.org>
# This program is Free Software see LICENSE file for details

"""Anaconda.PHP phpcs lint wrapper
"""

import os
import subprocess
try:
    import ujson as json
except ImportError:
    import json

from helpers import create_subprocess

PIPE = subprocess.PIPE


class PHPCSLinter(object):
    """PHPCSLinter class for Anaconda.PHP
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

        phpcs = os.path.join(os.path.dirname(__file__), 'phpcs/scripts/phpcs')
        args = [
            'php', phpcs, '--extensions=php,inc,lib,js,css', '--report=json',
            '--standard={0}'.format(
                self.settings.get('phpcs_standard', 'PRS2')
            )
        ]
        args.append('--severity={0}'.format(
            self.settings.get('phpcs_severity', 1))
        )

        if self.settings.get('phpcs_tabs2spaces', True):
            args.append('--tab-width=4')

        if self.settings.get('phpcs_no_warnings', False):
            args.append('-n')

        for arg in self.settings.get('phpcs_additional_arguments', []):
            args.append(arg)

        args.append(self.filename)
        proc = create_subprocess(args, stdout=PIPE, cwd=os.getcwd())
        self.output, self.error = proc.communicate()

    def parse_errors(self):
        """Parse the JSON output given by phpcs --report=json
        """

        if self.error is not None:
            raise RuntimeError(self.error)

        errors = {'E': [], 'W': [], 'V': []}
        # phpcs errors are treated as warnings and warnings as violations
        errors_map = {'E': 'W', 'W': 'V'}
        report = json.loads(self.output)

        if report['totals']['errors'] + report['totals']['warnings'] > 0:
            for error_msg in report['files'].values()[0]['messages']:
                errors[errors_map[error_msg['type'][0]]].append({
                    'line': error_msg['line'],
                    'offset': error_msg['column'],
                    'message': error_msg['message'],
                    'code': 0,
                    'message': '[{0}] phpcs ({1}): {2}'.format(
                        error_msg['type'][0],
                        error_msg['severity'],
                        error_msg['message']
                    )
                })

        return errors
