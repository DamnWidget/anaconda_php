
# Copyright (C) 2014 - Oscar Campos <oscar.campos@member.fsf.org>
# This program is Free Software see LICENSE file for details

"""AnacondaPHP is a PHP linting plugin for Sublime Text 3
"""

from .plugin_version import anaconda_required_version

from anaconda.version import version as anaconda_version

if anaconda_required_version > anaconda_version:
    raise RuntimeError(
        'AnacondaPHP requires version {} or better of anaconda but {} '
        'is installed'.format(
            '.'.join([str(i) for i in anaconda_required_version]),
            '.'.join([str(i) for i in anaconda_version])
        )
    )

from .commands import *
from .listeners import *
