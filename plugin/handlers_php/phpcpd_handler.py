
# Copyright (C) 2014 - Oscar Campos <oscar.campos@member.fsf.org>
# This program is Free Software see LICENSE file for details

from lib import anaconda_handler

from .commands import PHPCPD


class PHPCPDHandler(anaconda_handler.AnacondaHandler):
    """Handle requests to execute phpcpd command from the JsonServer
    """

    __handler_type__ = 'phpcpd'

    def php_copy_and_paste_detector(self, filename=None, settings=None):
        """Run the phpcpd in a file or directory
        """

        PHPCPD(self.callback, self.uid, self.vid, filename, settings)
