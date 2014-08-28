
# Copyright (C) 2014 - Oscar Campos <oscar.campos@member.fsf.org>
# This program is Free Software see LICENSE file for details

from lib import anaconda_handler

from commands import PHPCSFixer


class PHPFixerHandler(anaconda_handler.AnacondaHandler):
    """Handle requests to execute php-cs-fixer command from the JsonServer
    """

    __handler_type__ = 'php_cs_fixer'

    def phpcs_fixer(self, filename=None, settings=None):
        """Run the php-cs-fixer in a file
        """

        PHPCSFixer(self.callback, self.uid, self.vid, filename, settings)
