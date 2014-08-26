
# Copyright (C) 2014 - Oscar Campos <oscar.campos@member.fsf.org>
# This program is Free Software see LICENSE file for details

import sublime

from anaconda.anaconda_lib import helpers as anaconda_helpers

NONE = 0x00
ONLY_PHP = 0x01
NOT_SCRATCH = 0x02
LINTING_ENABLED = 0x04


def check_linting(view, mask):
    """Check common linting constraints
    """

    if mask & ONLY_PHP and not is_php(view, ignore_comments=True):
        return False

    if mask & NOT_SCRATCH and view.is_scratch():
        return False

    if (mask & LINTING_ENABLED
            and not get_settings(view, 'anaconda_linting', False)):
        return False

    return True


def check_linting_behaviour(view, behaviours):
    """Make sure the correct behaviours are applied
    """

    b = get_settings(view, 'anaconda_linting_behaviour', 'always')
    return b in behaviours


def is_php(view, ignore_comments=False):
    """Determine if the given view location is php code
    """

    if view is None:
        return False

    try:
        location = view.sel()[0].begin()
    except IndexError:
        return False

    if ignore_comments is True:
        matcher = 'source.php'
    else:
        matcher = 'source.php - string - comment'

    return view.match_selector(location, matcher)


def get_settings(view, name, default=None):
    """Get settings
    """

    if view is None:
        return None

    plugin_settings = sublime.load_settings('AnacondaPHP.sublime-settings')
    return view.settings().get(name, plugin_settings.get(name, default))


# reuse anaconda helper functions
create_subprocess = anaconda_helpers.create_subprocess
prepare_send_data = anaconda_helpers.prepare_send_data
get_window_view = anaconda_helpers.get_window_view
get_traceback = anaconda_helpers.get_traceback
project_name = anaconda_helpers.project_name
active_view = anaconda_helpers.active_view
get_view = anaconda_helpers.get_view


__all__ = [
    'check_linting', 'check_linting_behaviour', 'is_php', 'get_settings',
    'create_subprocess', 'prepare_send_data', 'get_window_view',
    'get_traceback', 'project_name', 'active_view', 'get_view'
]
