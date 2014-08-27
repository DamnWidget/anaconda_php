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
 * Test case for the {@link \PDepend\Source\AST\ASTLiteral} class.
 *
 * @copyright 2008-2013 Manuel Pichler. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 *
 * @covers \PDepend\Source\Language\PHP\AbstractPHPParser
 * @covers \PDepend\Source\AST\ASTLiteral
 * @group unittest
 */
class ASTLiteralTest extends \PDepend\Source\AST\ASTNodeTest
{
    /**
     * testLiteralWithBooleanTrueExpression
     *
     * @return void
     */
    public function testLiteralWithBooleanTrueExpression()
    {
        $literal = $this->_getFirstLiteralInFunction();
        $this->assertEquals('True', $literal->getImage());
    }

    /**
     * testLiteralWithBooleanFalseExpression
     *
     * @return void
     */
    public function testLiteralWithBooleanFalseExpression()
    {
        $literal = $this->_getFirstLiteralInFunction();
        $this->assertEquals('False', $literal->getImage());
    }

    /**
     * testLiteralWithIntegerExpression
     *
     * @return void
     */
    public function testLiteralWithIntegerExpression()
    {
        $literal = $this->_getFirstLiteralInFunction();
        $this->assertEquals('42', $literal->getImage());
    }

    /**
     * testLiteralWithSignedIntegerExpression
     *
     * @return void
     */
    public function testLiteralWithSignedIntegerExpression()
    {
        $literal = $this->_getFirstLiteralInFunction();
        $this->assertEquals('42', $literal->getImage());
    }

    /**
     * testLiteralWithFloatExpression
     *
     * @return void
     */
    public function testLiteralWithFloatExpression()
    {
        $literal = $this->_getFirstLiteralInFunction();
        $this->assertEquals('42.23', $literal->getImage());
    }

    /**
     * testLiteralWithSignedFloatExpression
     *
     * @return void
     */
    public function testLiteralWithSignedFloatExpression()
    {
        $literal = $this->_getFirstLiteralInFunction();
        $this->assertEquals('42.23', $literal->getImage());
    }

    /**
     * testLiteralWithNullExpression
     *
     * @return void
     */
    public function testLiteralWithNullExpression()
    {
        $literal = $this->_getFirstLiteralInFunction();
        $this->assertEquals('NULL', $literal->getImage());
    }

    /**
     * testLiteralWithZeroIntegerValue
     *
     * @return void
     * @since 1.0.0
     */
    public function testLiteralWithZeroIntegerValue()
    {
        $literal = $this->_getFirstLiteralInFunction();
        $this->assertEquals('0', $literal->getImage());
    }

    /**
     * testLiteralWithZeroOctalIntegerValue
     *
     * @return void
     * @since 1.0.0
     */
    public function testLiteralWithZeroOctalIntegerValue()
    {
        $literal = $this->_getFirstLiteralInFunction();
        $this->assertEquals('00', $literal->getImage());
    }

    /**
     * testLiteralWithZeroHexIntegerValue
     *
     * @return void
     * @since 1.0.0
     */
    public function testLiteralWithZeroHexIntegerValue()
    {
        $literal = $this->_getFirstLiteralInFunction();
        $this->assertEquals('0x0', $literal->getImage());
    }

    /**
     * testLiteralWithZeroBinaryIntegerValue
     *
     * @return void
     * @since 1.0.0
     */
    public function testLiteralWithZeroBinaryIntegerValue()
    {
        $literal = $this->_getFirstLiteralInFunction();
        $this->assertEquals('0b0', $literal->getImage());
    }

    /**
     * testLiteralWithNonZeroOctalIntegerValue
     *
     * @return void
     * @since 1.0.0
     */
    public function testLiteralWithNonZeroOctalIntegerValue()
    {
        $literal = $this->_getFirstLiteralInFunction();
        $this->assertEquals('02342', $literal->getImage());
    }

    /**
     * testLiteralWithNonZeroHexIntegerValue
     *
     * @return void
     * @since 1.0.0
     */
    public function testLiteralWithNonZeroHexIntegerValue()
    {
        $literal = $this->_getFirstLiteralInFunction();
        $this->assertEquals('0x926', $literal->getImage());
    }

    /**
     * testLiteralWithNonZeroBinaryIntegerValue
     *
     * @return void
     * @since 1.0.0
     */
    public function testLiteralWithNonZeroBinaryIntegerValue()
    {
        $literal = $this->_getFirstLiteralInFunction();
        $this->assertEquals('0b100100100110', $literal->getImage());
    }

    /**
     * testLiteralWithBrokenBinaryIntegerThrowsExpectedException
     *
     * @return void
     * @since 1.0.0
     * @expectedException \PDepend\Source\Parser\UnexpectedTokenException
     */
    public function testLiteralWithBrokenBinaryIntegerThrowsExpectedException()
    {
        if (version_compare(phpversion(), '5.4alpha') >= 0) {
            $this->markTestSkipped('This test only affects PHP < 5.4');
        }
        $this->_getFirstLiteralInFunction();
    }

    /**
     * testLiteralWithCurlyBraceFollowedByCompoundExpression
     *
     * @return void
     * @since 1.0.0
     */
    public function testLiteralWithCurlyBraceFollowedByCompoundExpression()
    {
        $literal = $this->_getFirstLiteralInFunction();
        $this->assertEquals('{', $literal->getImage());
    }

    /**
     * Tests that an invalid literal results in the expected exception.
     * 
     * @return void
     * @expectedException \PDepend\Source\Parser\TokenStreamEndException
     */
    public function testUnclosedDoubleQuoteStringResultsInExpectedException()
    {
        self::parseCodeResourceForTest();
    }

    /**
     * Creates a literal node.
     *
     * @return \PDepend\Source\AST\ASTLiteral
     */
    protected function createNodeInstance()
    {
        return new \PDepend\Source\AST\ASTLiteral("'" . __METHOD__ . "'");
    }

    /**
     * Returns a node instance for the currently executed test case.
     *
     * @return \PDepend\Source\AST\ASTLiteral
     */
    private function _getFirstLiteralInFunction()
    {
        return $this->getFirstNodeOfTypeInFunction(
            self::getCallingTestMethod(),
            'PDepend\\Source\\AST\\ASTLiteral'
        );
    }
}
