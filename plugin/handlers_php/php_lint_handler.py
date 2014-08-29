
# Copyright (C) 2014 - Oscar Campos <oscar.campos@member.fsf.org>
# This program is Free Software see LICENSE file for details

from functools import partial

from lib import anaconda_handler
from .linting.anaconda_phpmess import PHPMess
from .linting.anaconda_phplint import PHPLint
from .linting.anaconda_phpcslint import PHPCSLint
from .commands import PHPLinter, PHPCSLinter, PHPMessChecker


class PHPLintHandler(anaconda_handler.AnacondaHandler):
    """Handle requests to execute PHP linting commands from the JsonServer
    """

    __handler_type__ = 'php_linter'

    def __init__(self, command, data, uid, vid, callback, debug=False):
        self.uid = uid
        self.vid = vid
        self.data = data
        self.debug = debug
        self.callback = callback
        self.command = command
        self._linters = {'phplint': True, 'phpcs': True, 'phpmess': True}
        self._errors = []
        self._failures = []

    def lint(self, settings, code=None, filename=None):
        """This is called from the JsonServer
        """

        self._configure_linters(settings)
        for linter_name, expected in self._linters.items():
            if expected is True:
                func = getattr(self, linter_name)
                func(settings, code, filename)

        if len(self._errors) == 0 and len(self._failures) > 0:
            return {
                'success': False,
                'errors': '. '.join([str(e) for e in self._failures]),
                'uid': self.uid,
                'vid': self.vid
            }

        return {
            'success': True,
            'errors': self._errors,
            'uid': self.uid,
            'vid': self.vid
        }

    def phplint(self, settings, code=None, filename=None):
        """Run the php linter
        """

        PHPLinter(
            partial(self._normalize, settings),
            self.uid, self.vid, PHPLint, settings, code, filename
        )

    def phpcs(self, settings, code=None, filename=None):
        """Run the phpcs linter
        """

        PHPCSLinter(
            partial(self._normalize, settings),
            self.uid, self.vid, PHPCSLint, settings, code, filename
        )

    def phpmd(self, settings, code=None, filename=None):
        """Run the phpmd linter
        """

        PHPMessChecker(
            partial(self._normalize, settings),
            self.uid, self.vid, PHPMess, settings, code, filename
        )

    def _normalize(self, settings, data):
        """Normalize linters data before to merge
        """

        normalized_errors = []
        for error_level, error_data in data.get('errors', {}).items():
            for error in error_data:
                normalized_error = {
                    'underline_range': True,
                    'level': error_level,
                    'message': error['message'],
                    'offset': int(error.get('offset', 0)),
                    'lineno': int(error['line'])
                }
                normalized_errors.append(normalized_error)

        if data.get('errors') is not None:
            data['errors'] = normalized_errors

        self._merge(data)

    def _configure_linters(self, settings):
        """Enable or disable linters
        """

        self._linters['phplint'] = settings.get('use_phplint')
        self._linters['phpcs'] = settings.get('use_phpcs')
        self._linters['phpmess'] = settings.get('use_phpmess')

    def _merge(self, lint_result):
        """Merge the given linter result
        """

        if lint_result['success'] is True:
            self._errors += lint_result['errors']
        else:
            self._failures.append(lint_result['error'])
