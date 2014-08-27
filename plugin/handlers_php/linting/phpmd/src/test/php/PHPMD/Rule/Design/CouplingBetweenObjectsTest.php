<?php
/**
 * This file is part of PHP Mess Detector.
 *
 * PHP Version 5
 *
 * Copyright (c) 2008-2012, Manuel Pichler <mapi@phpmd.org>.
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
 *_Design
 * @author    Manuel Pichler <mapi@phpmd.org>
 * @copyright 2008-2014 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version   @project.version@
 */

namespace PHPMD\Rule\Design;

use PHPMD\AbstractTest;

/**
 * Test case for the {@link \PHPMD\Rule\Design\CouplingBetweenObjects} class.
 *_Design
 * @author    Manuel Pichler <mapi@phpmd.org>
 * @copyright 2008-2014 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version   @project.version@
 *
 * @ticket 10474987
 * @covers \PHPMD\Rule\Design\CouplingBetweenObjects
 * @group phpmd
 * @group phpmd::rule
 * @group phpmd::rule::design
 */
class CouplingBetweenObjectsTest extends AbstractTest
{
    /**
     * testRuleNotAppliesToClassWithCboLessThanThreshold
     * 
     * @return void
     */
    public function testRuleNotAppliesToClassWithCboLessThanThreshold()
    {
        $rule = new CouplingBetweenObjects();
        $rule->setReport($this->getReportMock(0));
        $rule->addProperty('minimum', '42');
        $rule->apply($this->getClassMock('cbo', 41));
    }

    /**
     * testRuleAppliesToClassWithCboEqualToThreshold
     *
     * @return void
     */
    public function testRuleAppliesToClassWithCboEqualToThreshold()
    {
        $rule = new CouplingBetweenObjects();
        $rule->setReport($this->getReportMock(1));
        $rule->addProperty('minimum', '42');
        $rule->apply($this->getClassMock('cbo', 42));
    }

    /**
     * testRuleAppliesToClassWithCboGreaterThanThreshold
     *
     * @return void
     */
    public function testRuleAppliesToClassWithCboGreaterThanThreshold()
    {
        $rule = new CouplingBetweenObjects();
        $rule->setReport($this->getReportMock(1));
        $rule->addProperty('minimum', '41');
        $rule->apply($this->getClassMock('cbo', 42));
    }
}
