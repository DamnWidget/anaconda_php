
# Copyright (C) 2013 - Oscar Campos <oscar.campos@member.fsf.org>
# This program is Free Software see LICENSE file for details

from functools import partial

import sublime as st3_sublime

from .helpers import get_settings, active_view
from .anaconda_plugin import anaconda_sublime, Worker, Callback


def run_linter(view=None):
    """Run the linter for the given view
    """

    if view is None:
        view = active_view()

    if not get_settings(view, 'anaconda_php_linting', False):
        return

    if view.file_name() in anaconda_sublime.ANACONDA['DISABLED']:
        anaconda_sublime.erase_lint_marks(view)
        return

    settings = {
        'use_phpcs': get_settings(view, 'use_phpcs', True),
        'use_phpmd': get_settings(view, 'use_phpmd', True),
        'use_phplint': get_settings(view, 'use_phplint', True),
        'use_phpcpd': get_settings(view, 'use_phpcpd', True),
        'phpcs_severity': get_settings(view, 'phpcs_severity', 1),
        'phpcs_standard': get_settings(view, 'phpcs_standard', 'PSR2'),
        'phpcs_tab2spaces': get_settings(view, 'phpcs_tab2spaces', True),
        'phpcs_no_warnings': get_settings(view, 'phpcs_no_warnings', False),
        'phpmd_ruleset': get_settings(view, 'phpmd_ruleset', ['unusedcode']),
        'phpcs_additional_arguments': get_settings(
            view, 'phpcs_additional_arguments', []),
        'phpcs_additional_arguments': get_settings(
            view, 'phpcs_additional_arguments', []),
        'phpmd_additional_arguments': get_settings(
            view, 'phpmd_additional_arguments', [])
    }

    text = view.substr(st3_sublime.Region(0, view.size()))
    data = {
        'vid': view.id(),
        'code': text,
        'settings': settings,
        'filename': view.file_name(),
        'method': 'lint',
        'handler': 'php_linter'
    }

    callback = partial(anaconda_sublime.parse_results, **dict(code='php'))
    Worker().execute(Callback(on_success=callback), **data)
