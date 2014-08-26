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
 * Test case for the {@link \PDepend\Source\AST\ASTString} class.
 *
 * @copyright 2008-2013 Manuel Pichler. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 *
 * @covers \PDepend\Source\Language\PHP\AbstractPHPParser
 * @covers \PDepend\Source\AST\ASTString
 * @group unittest
 */
class ASTStringTest extends \PDepend\Source\AST\ASTNodeTest
{
    /**
     * testDoubleQuoteStringContainsTwoChildNodes
     *
     * @return void
     */
    public function testDoubleQuoteStringContainsTwoChildNodes()
    {
        $string = $this->_getFirstStringInFunction(__METHOD__);
        $this->assertEquals(2, count($string->getChildren()));
    }

    /**
     * testDoubleQuoteStringContainsExpectedTextContent
     *
     * @return void
     */
    public function testDoubleQuoteStringContainsExpectedTextContent()
    {
        $string = $this->_getFirstStringInFunction(__METHOD__);
        $this->assertContains("Hello", $string->getChild(0)->getImage());
    }

    /**
     * testBacktickExpressionContainsTwoChildNodes
     *
     * @return void
     */
    public function testBacktickExpressionContainsTwoChildNodes()
    {
        $string = $this->_getFirstStringInFunction(__METHOD__);
        $this->assertEquals(2, count($string->getChildren()));
    }

    /**
     * testBacktickExpressionContainsExpectedCompoundVariable
     *
     * @return void
     */
    public function testBacktickExpressionContainsExpectedCompoundVariable()
    {
        $string = $this->_getFirstStringInFunction(__METHOD__);
        $this->assertInstanceOf('PDepend\\Source\\AST\\ASTCompoundVariable', $string->getChild(0));
    }

    /**
     * testDoubleQuoteStringWithEmbeddedComplexBacktickExpression
     *
     * @return void
     */
    public function testDoubleQuoteStringWithEmbeddedComplexBacktickExpression()
    {
        $string = $this->_getFirstStringInFunction(__METHOD__);
        $actual = array();
        foreach ($string->getChildren() as $child) {
            $actual[] = $child->getImage();
        }
        $expected = array("Issue `", '$ticketNo', '`');

        $this->assertEquals($expected, $actual);
    }

    /**
     * testBacktickExpressionWithEmbeddedComplexDoubleQuoteString
     *
     * @return void
     */
    public function testBacktickExpressionWithEmbeddedComplexDoubleQuoteString()
    {
        $string = $this->_getFirstStringInFunction(__METHOD__);
        $actual = array();
        foreach ($string->getChildren() as $child) {
            $actual[] = $child->getImage();
        }
        $expected = array('Issue "', '$ticketNo', '"');
        
        $this->assertEquals($expected, $actual);
    }

    /**
     * testDoubleQuoteStringContainsVariable
     *
     * @return void
     */
    public function testDoubleQuoteStringContainsVariable()
    {
        $string = $this->_getFirstStringInFunction(__METHOD__);
        $this->assertInstanceOf('PDepend\\Source\\AST\\ASTVariable', $string->getChild(0));
    }

    /**
     * testDoubleQuoteStringContainsVariableAfterNotOperator
     *
     * @return void
     */
    public function testDoubleQuoteStringContainsVariableAfterNotOperator()
    {
        $string = $this->_getFirstStringInFunction(__METHOD__);
        $this->assertInstanceOf('PDepend\\Source\\AST\\ASTVariable', $string->getChild(1));
    }

    /**
     * testDoubleQuoteStringContainsVariableAfterSilenceOperator
     *
     * @return void
     */
    public function testDoubleQuoteStringContainsVariableAfterSilenceOperator()
    {
        $string = $this->_getFirstStringInFunction(__METHOD__);
        $this->assertInstanceOf('PDepend\\Source\\AST\\ASTVariable', $string->getChild(1));
    }

    /**
     * testDoubleQuoteStringContainsCompoundVariable
     *
     * @return void
     */
    public function testDoubleQuoteStringContainsCompoundVariable()
    {
        $string = $this->_getFirstStringInFunction(__METHOD__);
        $this->assertInstanceOf('PDepend\\Source\\AST\\ASTCompoundVariable', $string->getChild(0));
    }

    /**
     * testDoubleQuoteStringContainsCompoundExpressionAfterLiteral
     *
     * @return void
     */
    public function testDoubleQuoteStringContainsCompoundExpressionAfterLiteral()
    {
        $string = $this->_getFirstStringInFunction(__METHOD__);
        $this->assertInstanceOf('PDepend\\Source\\AST\\ASTCompoundExpression', $string->getChild(1));
    }

    /**
     * testDoubleQuoteStringContainsVariableAfterDollarTwoLiterals
     *
     * @return void
     */
    public function testDoubleQuoteStringContainsVariableAfterDollarTwoLiterals()
    {
        $string = $this->_getFirstStringInFunction(__METHOD__);
        $this->assertInstanceOf('PDepend\\Source\\AST\\ASTVariable', $string->getChild(1));
    }

    /**
     * testDoubleQuoteStringContainsDollarLiteralForVariableVariable
     *
     * @return void
     */
    public function testDoubleQuoteStringContainsDollarLiteralForVariableVariable()
    {
        $string = $this->_getFirstStringInFunction(__METHOD__);
        $this->assertInstanceOf('PDepend\\Source\\AST\\ASTLiteral', $string->getChild(0));
    }

    /**
     * Tests that an invalid literal results in the expected exception.
     *
     * @return void
     * @expectedException \PDepend\Source\Parser\TokenException
     */
    public function testUnclosedDoubleQuoteStringResultsInExpectedException()
    {
        self::parseCodeResourceForTest();
    }

    /**
     * Creates a string node.
     *
     * @return \PDepend\Source\AST\ASTString
     */
    protected function createNodeInstance()
    {
        return new \PDepend\Source\AST\ASTString();
    }

    /**
     * Returns a test member primary prefix.
     *
     * @param string $testCase The calling test case.
     *
     * @return \PDepend\Source\AST\ASTString
     */
    private function _getFirstStringInFunction($testCase)
    {
        return $this->getFirstNodeOfTypeInFunction(
            $testCase,
            'PDepend\\Source\\AST\\ASTString'
        );
    }
}
