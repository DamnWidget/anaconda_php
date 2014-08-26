
# Copyright (C) 2014 - Oscar Campos <oscar.campos@member.fsf.org>
# This program is Free Software see LICENSE file for details


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
    from anaconda.anaconda_lib.linting.linter import LintError
    from anaconda.anaconda_server.jsonserver import JSONHandler, start_server

    __all__ += ['JSONHandler', 'start_server', 'LintError']
