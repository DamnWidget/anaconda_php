<?php
/**
 * This file is part of PDepend.
 *
 * PHP Version 5
 *
 * Copyright (c) 2008-2013, Manuel Pichler <mapi@pdepend.org>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Manuel Pichler nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @copyright 2008-2013 Manuel Pichler. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link       https://www.pivotaltracker.com/story/show/21500611
 * @since     1.0.0
 */

namespace PDepend\Bugs;

use PDepend\Source\AST\ASTHeredoc;

/**
 * Test case for bug #21500611.
 *
 * @copyright 2008-2013 Manuel Pichler. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link https://www.pivotaltracker.com/story/show/21500611
 * @since 1.0.0
 *
 * @ticket 21500611
 * @covers \stdClass
 * @group regressiontest
 */
class ParserBug21500611Test extends AbstractRegressionTest
{
    /**
     * testParserHandlesNowdocInPropertyDeclaration
     *
     * @return void
     */
    public function testParserHandlesNowdocInPropertyDeclaration()
    {
        $this->assertNull($this->getFirstHeredocInClass());
    }

    /**
     * testParserHandlesNowdocInStaticVariableDeclaration
     *
     * @return void
     */
    public function testParserHandlesNowdocInStaticVariableDeclaration()
    {
        $this->assertNull($this->getFirstHeredocInClass());
    }

    /**
     * testParserHandlesNowdocForMultipleStaticVariableDeclarations
     *
     * @return void
     */
    public function testParserHandlesNowdocForMultipleStaticVariableDeclarations()
    {
        $this->assertNull($this->getFirstHeredocInClass());
    }

    /**
     * testParserHandlesNowdocInParameterDefaultValue
     *
     * @return void
     */
    public function testParserHandlesNowdocInParameterDefaultValue()
    {
        $this->assertNull($this->getFirstHeredocInClass());
    }

    /**
     * testParserHandlesNowdocForMultipleParametersDefaultValue
     *
     * @return void
     */
    public function testParserHandlesNowdocForMultipleParametersDefaultValue()
    {
        $this->assertNull($this->getFirstHeredocInClass());
    }

    /**
     * Returns the first heredoc found in a class.
     *
     * @return \PDepend\Source\AST\ASTHeredoc
     */
    protected function getFirstHeredocInClass()
    {
        return self::parseCodeResourceForTest()
            ->current()
            ->getClasses()
            ->current()
            ->getFirstChildOfType('PDepend\\Source\\AST\\ASTHeredoc');
    }
}
