
# Copyright (C) 2014 - Oscar Campos <oscar.campos@member.fsf.org>
# This program is Free Software see LICENSE file for details


from ..anaconda_lib.sublime import run_linter

from anaconda.listeners import linting


class BackgroundLinter(linting.BackgroundLinter):
    """Background linter, can be turned off via plugin settings
    """

    def __init__(self):
        kwargs = {'lang': 'PHP', 'linter': run_linter}
        super(BackgroundLinter, self).__init__(**kwargs)
        self.check_auto_lint = True

    def on_modified(self, view):
        """PHP tools doesn't works on buffer, just in files
        """
        pass
