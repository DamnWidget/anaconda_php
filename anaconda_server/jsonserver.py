
# Copyright (C) 2014 - Oscar Campos <oscar.campos@member.fsf.org>
# This program is Free Software see LICENSE file for details

from ..anaconda_lib import anaconda_plugin
from ..plugin_version import version, anaconda_version

from handlers import ANACONDA_PHP_HANDLERS

DEBUG_MODE = True


class JSONHandler(anaconda_plugin.JSONHandler):
    """
    Proxy class that add the reuired handlers to parse, correct and
    lint PHP code through the Anaconda's JsonServer and Asynchronous
    network mechanisms
    """

    def __init__(self, sock, server):
        if anaconda_plugin.version < anaconda_version:
            raise RuntimeError(
                'Anaconda.PHP v{}.{}.{} requires at least v{}.{}.{} '
                'of Anaconda '.format(*(version + anaconda_version))
            )

        super(JSONHandler, self).__init__(sock, server)

    def handler_command(self, handler_type, method, uid, vid, data):
        """Call the right commands handler
        """

        handler = ANACONDA_PHP_HANDLERS[handler_type]
        handler(method, data, uid, vid, self.return_back, DEBUG_MODE).run()


if __name__ == '__main__':
    anaconda_plugin.start_server(JSONHandler)
