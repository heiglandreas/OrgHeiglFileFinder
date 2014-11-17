<?php
/**
 * Copyright (c)2014-2014 heiglandreas
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIBILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category 
 * @author    Andreas Heigl<andreas@heigl.org>
 * @copyright ©2014-2014 Andreas Heigl
 * @license   http://www.opesource.org/licenses/mit-license.php MIT-License
 * @version   0.0
 * @since     14.11.14
 * @link      https://github.com/heiglandreas/
 */

namespace Org_HeiglTest\FileFinder\Filter;


use Org_Heigl\FileFinder\Filter\DateCompare;
use Mockery as M;

class DateCompareTest extends \PHPUnit_Framework_TestCase
{
    public function testCreationOfInstance()
    {
        $dt = M::mock('\DateTime');

        $obj = new DateCompare($dt);

        $this->assertAttributeInstanceof('\DateTime', 'compareDate', $obj);
        $this->assertAttributeEquals(DateCompare::DATE_M, 'compareType', $obj);
        $this->assertAttributeEquals(DateCompare::CHECK_EQUAL, 'compareAction', $obj);
    }

    public function testCreationOfInstanceWith2Params()
    {
        $dt = M::mock('\DateTime');

        $obj = new DateCompare($dt, DateCompare::DATE_A);

        $this->assertAttributeInstanceof('\DateTime', 'compareDate', $obj);
        $this->assertAttributeEquals(DateCompare::DATE_A, 'compareType', $obj);
        $this->assertAttributeEquals(DateCompare::CHECK_EQUAL, 'compareAction', $obj);
    }

    public function testCreationWith3Params()
    {
        $dt = M::mock('\DateTime');

        $obj = new DateCompare($dt, DateCompare::DATE_A, DateCompare::CHECK_AFTER);

        $this->assertAttributeInstanceof('\DateTime', 'compareDate', $obj);
        $this->assertAttributeEquals(DateCompare::DATE_A, 'compareType', $obj);
        $this->assertAttributeEquals(DateCompare::CHECK_AFTER, 'compareAction', $obj);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreationWithWrongParams()
    {
        $dt = M::mock('\DateTime');

        new DateCompare($dt, 'foo', DateCompare::CHECK_AFTER);

    }

    /**
     * @dataProvider comparisonProvider
     */
    public function testComparison($date, $comparedate, $type, $action, $result)
    {
        $mock = M::mock('\SPLFileInfo');
        $mock->shouldReceive('get' . $type)->once()->andReturn($comparedate->getTimestamp());

        $obj = new DateCompare($date, $type, $action);
        $this->assertEquals($result, $obj->filter($mock));

    }

    public function comparisonProvider()
    {
        return array(
            array(new \DateTime('2014-12-13T12:23:34+00:00'), new \DateTime('2014-12-13T12:23:34+00:00'), DateCompare::DATE_A, DateCompare::CHECK_EQUAL, true),
            array(new \DateTime('2014-12-13T12:23:34+00:00'), new \DateTime('2014-12-13T12:23:33+00:00'), DateCompare::DATE_A, DateCompare::CHECK_EQUAL, false),
            array(new \DateTime('2014-12-13T12:23:34+00:00'), new \DateTime('2014-12-13T12:23:33+00:00'), DateCompare::DATE_A, DateCompare::CHECK_AFTER, false),
            array(new \DateTime('2014-12-13T12:23:34+00:00'), new \DateTime('2014-12-13T12:23:33+00:00'), DateCompare::DATE_A, DateCompare::CHECK_BEFORE, true),
            array(new \DateTime('2014-12-13T12:23:33+00:00'), new \DateTime('2014-12-13T12:23:34+00:00'), DateCompare::DATE_A, DateCompare::CHECK_EQUAL, false),
            array(new \DateTime('2014-12-13T12:23:33+00:00'), new \DateTime('2014-12-13T12:23:34+00:00'), DateCompare::DATE_A, DateCompare::CHECK_AFTER, true),
            array(new \DateTime('2014-12-13T12:23:33+00:00'), new \DateTime('2014-12-13T12:23:34+00:00'), DateCompare::DATE_A, DateCompare::CHECK_BEFORE, false),
        );
    }

}
