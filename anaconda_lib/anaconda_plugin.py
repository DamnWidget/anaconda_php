
# Copyright (C) 2014 - Oscar Campos <oscar.campos@member.fsf.org>
# This program is Free Software see LICENSE file for details

import os
import sys
ANACONDA_PLUGIN_AVAILABLE = False
try:
    from anaconda import anaconda as plugin
except ImportError:
    try:
        from Anaconda import anaconda as plugin
        assert plugin
    except ImportError:
        raise RuntimeError('Anaconda plugin is not installed!')
    else:
        ANACONDA_PLUGIN_AVAILABLE = True
else:
    ANACONDA_PLUGIN_AVAILABLE = True


__all__ = ['ANACONDA_PLUGIN_AVAILABLE']

if ANACONDA_PLUGIN_AVAILABLE:
    # we need this to dont get ImportError in jsonsever
    sys.path.append(
        os.path.join(os.path.dirname(plugin.__file__), 'anaconda_server')
    )
    from anaconda.anaconda_lib.worker import Worker
    from anaconda.anaconda_lib.callback import Callback
    from anaconda.anaconda_lib.linting import sublime as anaconda_sublime

    __all__ += ['Worker', 'Callback', 'anaconda_sublime']
