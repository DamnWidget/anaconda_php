
# Copyright (C) 2014 - Oscar Campos <oscar.campos@member.fsf.org>
# This program is Free Software see LICENSE file for details

from .php_linter import PHPLintHandler
from .autoformat import AutoformatHandler

ANACONDA_PHP_HANDLERS = {
    'php_linter': PHPLintHandler,
    'autoformat': AutoformatHandler
}

__all__ = ['PHPLintHandler', 'AutoformatHandler', 'ANACONDA_PHP_HANDLERS']
