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
 */

namespace PDepend\Source\AST;

/**
 * Test case for the {@link \PDepend\Source\AST\ASTArguments} class.
 *
 * @copyright 2008-2013 Manuel Pichler. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 *
 * @covers \PDepend\Source\Language\PHP\AbstractPHPParser
 * @covers \PDepend\Source\AST\ASTArguments
 * @group unittest
 */
class ASTArgumentsTest extends \PDepend\Source\AST\ASTNodeTest
{
    /**
     * testArgumentsGraphWithMagicClassConstant
     *
     * @return void
     * @since 1.0.0
     */
    public function testArgumentsGraphWithMagicClassConstant()
    {
        $arguments = $this->_getFirstArgumentsOfFunction();
        $this->assertGraph(
            $arguments,
            array(
                'PDepend\\Source\\AST\\ASTConstant'         . ' (__CLASS__)',
                'PDepend\\Source\\AST\\ASTLiteral'          . ' ("run")',
                'PDepend\\Source\\AST\\ASTArray'            . ' ()', array(
                    'PDepend\\Source\\AST\\ASTArrayElement' . ' ()', array(
                        'PDepend\\Source\\AST\\ASTVariable' . ' ($count)'))
            )
        );
    }

    /**
     * Tests the start line value of an arguments instance.
     *
     * @return void
     */
    public function testArgumentsHasExpectedStartLine()
    {
        $arguments = $this->_getFirstArgumentsOfFunction();
        $this->assertEquals(5, $arguments->getStartLine());
    }

    /**
     * Tests the start column value of an arguments instance.
     *
     * @return void
     */
    public function testArgumentsHasExpectedStartColumn()
    {
        $arguments = $this->_getFirstArgumentsOfFunction();
        $this->assertEquals(8, $arguments->getStartColumn());
    }

    /**
     * Tests the end line value of an arguments instance.
     *
     * @return void
     */
    public function testArgumentsHasExpectedEndLine()
    {
        $arguments = $this->_getFirstArgumentsOfFunction();
        $this->assertEquals(7, $arguments->getEndLine());
    }

    /**
     * Tests the end column value of an arguments instance.
     *
     * @return void
     */
    public function testArgumentsHasExpectedEndColumn()
    {
        $arguments = $this->_getFirstArgumentsOfFunction();
        $this->assertEquals(21, $arguments->getEndColumn());
    }

    /**
     * Returns an arguments instance for the currently executed test case.
     *
     * @return \PDepend\Source\AST\ASTArguments
     */
    private function _getFirstArgumentsOfFunction()
    {
        return $this->getFirstNodeOfTypeInFunction(
            $this->getCallingTestMethod(),
            'PDepend\\Source\\AST\\ASTArguments'
        );
    }
}
