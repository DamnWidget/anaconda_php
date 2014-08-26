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

use PDepend\Source\Builder\BuilderContext;

/**
 * Test case for the {@link \PDepend\Source\AST\ASTClassReference} class.
 *
 * @copyright 2008-2013 Manuel Pichler. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 *
 * @covers \PDepend\Source\Language\PHP\AbstractPHPParser
 * @covers \PDepend\Source\AST\ASTClassReference
 * @group unittest
 */
class ASTClassReferenceTest extends \PDepend\Source\AST\ASTNodeTest
{
    /**
     * testGetTypeDelegatesToBuilderContextGetClass
     *
     * @return void
     */
    public function testGetTypeDelegatesToBuilderContextGetClass()
    {
        $context = $this->getBuilderContextMock();
        $context->expects($this->once())
            ->method('getClass')
            ->with($this->equalTo(__CLASS__))
            ->will($this->returnValue($this));

        $reference = new \PDepend\Source\AST\ASTClassReference($context, __CLASS__);
        $reference->getType();
    }

    /**
     * testGetTypeCachesReturnValueOfBuilderContextGetClass
     *
     * @return void
     */
    public function testGetTypeCachesReturnValueOfBuilderContextGetClass()
    {
        $context = $this->getBuilderContextMock();
        $context->expects($this->exactly(1))
            ->method('getClass')
            ->with($this->equalTo(__CLASS__))
            ->will($this->returnValue($this));

        $reference = new \PDepend\Source\AST\ASTClassReference($context, __CLASS__);
        $reference->getType();
    }

    /**
     * testReturnValueOfMagicSleepContainsContextProperty
     *
     * @return void
     */
    public function testReturnValueOfMagicSleepContainsContextProperty()
    {
        $this->assertEquals(
            array(
                'context',
                'comment',
                'metadata',
                'nodes'
            ),
            $this->createNodeInstance()->__sleep()
        );
    }

    /**
     * testClassReferenceHasExpectedStartLine
     *
     * @return void
     */
    public function testClassReferenceHasExpectedStartLine()
    {
        $reference = $this->_getFirstReferenceInFunction(__METHOD__);
        $this->assertEquals(4, $reference->getStartLine());
    }

    /**
     * testClassReferenceHasExpectedStartColumn
     *
     * @return void
     */
    public function testClassReferenceHasExpectedStartColumn()
    {
        $reference = $this->_getFirstReferenceInFunction(__METHOD__);
        $this->assertEquals(16, $reference->getStartColumn());
    }

    /**
     * testClassReferenceHasExpectedEndLine
     *
     * @return void
     */
    public function testClassReferenceHasExpectedEndLine()
    {
        $reference = $this->_getFirstReferenceInFunction(__METHOD__);
        $this->assertEquals(4, $reference->getEndLine());
    }

    /**
     * testClassReferenceHasExpectedEndColumn
     *
     * @return void
     */
    public function testClassReferenceHasExpectedEndColumn()
    {
        $reference = $this->_getFirstReferenceInFunction(__METHOD__);
        $this->assertEquals(18, $reference->getEndColumn());
    }

    /**
     * testReferenceInClassExtendsHasExpectedStartLine
     *
     * @return void
     * @since 0.10.5
     */
    public function testReferenceInClassExtendsHasExpectedStartLine()
    {
        $reference = $this->_getFirstReferenceInClass();
        $this->assertEquals(2, $reference->getStartLine());
    }

    /**
     * testReferenceInClassExtendsHasExpectedStartColumn
     *
     * @return void
     * @since 0.10.5
     */
    public function testReferenceInClassExtendsHasExpectedStartColumn()
    {
        $reference = $this->_getFirstReferenceInClass();
        $this->assertEquals(65, $reference->getStartColumn());
    }

    /**
     * testReferenceInClassExtendsHasExpectedEndLine
     *
     * @return void
     * @since 0.10.5
     */
    public function testReferenceInClassExtendsHasExpectedEndLine()
    {
        $reference = $this->_getFirstReferenceInClass();
        $this->assertEquals(2, $reference->getEndLine());
    }

    /**
     * testReferenceInClassExtendsHasExpectedEndColumn
     *
     * @return void
     * @since 0.10.5
     */
    public function testReferenceInClassExtendsHasExpectedEndColumn()
    {
        $reference = $this->_getFirstReferenceInClass();
        $this->assertEquals(65, $reference->getEndColumn());
    }

    /**
     * Returns a node instance for the currently executed test case.
     *
     * @param string $testCase Name of the calling test case.
     *
     * @return \PDepend\Source\AST\ASTClassReference
     */
    private function _getFirstReferenceInFunction($testCase)
    {
        return $this->getFirstNodeOfTypeInFunction(
            $testCase, 'PDepend\\Source\\AST\\ASTClassReference'
        );
    }

    /**
     * Returns the first reference node for the currently executed test case.
     *
     * @return \PDepend\Source\AST\ASTClassReference
     * @since 0.10.5
     */
    private function _getFirstReferenceInClass()
    {
        return $this->getFirstNodeOfTypeInClass(
            self::getCallingTestMethod(),
            'PDepend\\Source\\AST\\ASTClassReference'
        );
    }

    /**
     * Creates a concrete node implementation.
     *
     * @return \PDepend\Source\AST\ASTNode
     */
    protected function createNodeInstance()
    {
        return new \PDepend\Source\AST\ASTClassReference(
            $this->getBuilderContextMock(),
            __CLASS__
        );
    }

    /**
     * Returns a mocked builder context instance.
     *
     * @return \PDepend\Source\Builder\BuilderContext
     */
    protected function getBuilderContextMock()
    {
        return $this->getMock('PDepend\\Source\\Builder\\BuilderContext');
    }
}
