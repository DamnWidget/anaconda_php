
# Copyright (C) 2014 - Oscar Campos <oscar.campos@member.fsf.org>
# This program is Free Software see LICENSE file for details

import logging
import traceback

from anaconda.anaconda_server.commands.base import Command


class PHPLinter(Command):
    """Run php -l linter and return back results
    """

    def __init__(self, callback, uid, vid, linter, settings, code, filename):
        self.vid = vid
        self.code = code
        self.linter = linter
        self.settings = settings
        self.filename = filename
        super(PHPLinter, self).__init__(callback, uid)

    def run(self):
        """Run the command
        """

        try:
            self.callback({
                'success': True,
                'errors': self.linter(
                    self.filename, self.settings).parse_errors(),
                'uid': self.uid,
                'vid': self.vid
            })
        except Exception as error:
            logging.error(error)
            logging.debug(traceback.format_exc())
            self.callback({
                'success': False,
                'error': error,
                'uid': self.uid,
                'vid': self.vid
            })
