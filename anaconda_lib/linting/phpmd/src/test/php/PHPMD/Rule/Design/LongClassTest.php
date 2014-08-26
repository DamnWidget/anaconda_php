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
 * Test case for the excessive long class rule.
 *_Design
 * @author    Manuel Pichler <mapi@phpmd.org>
 * @copyright 2008-2014 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version   @project.version@
 *
 * @covers \PHPMD\Rule\Design\LongClass
 * @group phpmd
 * @group phpmd::rule
 * @group phpmd::rule::design
 * @group unittest
 */
class LongClassTest extends AbstractTest
{
    /**
     * Tests that the rule applies for a value greater than the configured
     * threshold.
     *
     * @return void
     */
    public function testRuleAppliesForValueGreaterThanThreshold()
    {
        $class  = $this->getClassMock('loc', 42);
        $report = $this->getReportMock(1);

        $rule = new LongClass();
        $rule->setReport($report);
        $rule->addProperty('minimum', '41');
        $rule->addProperty('ignore-whitespace', false);
        $rule->apply($class);
    }

    /**
     * Test that the rule applies for a value that is equal with the configured
     * threshold.
     *
     * @return void
     */
    public function testRuleAppliesForValueEqualToThreshold()
    {
        $class  = $this->getClassMock('loc', 42);
        $report = $this->getReportMock(1);

        $rule = new LongClass();
        $rule->setReport($report);
        $rule->addProperty('minimum', '42');
        $rule->addProperty('ignore-whitespace', false);
        $rule->apply($class);
    }

    /**
     * Tests that the rule does not apply when the value is at least one lower
     * than the threshold.
     *
     * @return void
     */
    public function testRuleDoesNotApplyForValueLowerThanThreshold()
    {
        $class  = $this->getClassMock('loc', 22);
        $report = $this->getReportMock(0);

        $rule = new LongClass();
        $rule->setReport($report);
        $rule->addProperty('minimum', '23');
        $rule->addProperty('ignore-whitespace', false);
        $rule->apply($class);
    }

    /**
     * Tests that the rule uses eloc when ignore whitespace is set
     *
     * @return void
     */
    public function testRuleUsesElocWhenIgnoreWhitespaceSet()
    {
        $class  = $this->getClassMock('eloc', 22);
        $report = $this->getReportMock(0);

        $rule = new LongClass();
        $rule->setReport($report);
        $rule->addProperty('minimum', '23');
        $rule->addProperty('ignore-whitespace', true);
        $rule->apply($class);
    }
}
