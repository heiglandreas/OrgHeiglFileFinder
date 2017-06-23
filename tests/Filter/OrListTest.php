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
 * @since     07.11.14
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\FileFinderTest\Filter;


use Org_Heigl\FileFinder\Filter\OrList;
use Mockery as M;

class OrListTest extends \PHPUnit_Framework_TestCase
{
    public function testAddingFilters()
    {
        $filter = new OrList();
        $mocked = M::mock('\Org_Heigl\FileFinder\FilterInterface');

        $this->assertSame($filter, $filter->addFilter($mocked));
        $this->assertAttributeContainsOnly($mocked, 'filter', $filter);
    }

    public function testSettingFilterInConstructor()
    {
        $mocked = M::mock('\Org_Heigl\FileFinder\FilterInterface');
        $filter = new OrList(array($mocked));

        $this->assertAttributeContainsOnly($mocked, 'filter', $filter);
    }

    /**
     * @dataProvider filteringProvider
     */
    public function testFiltering($given, $expected)
    {

        $file   = M::mock('\SPLFileInfo');

        $filter = new OrList();
        foreach ($given as $give) {
            $mocked = M::mock('\Org_Heigl\FileFinder\FilterInterface');
            $mocked->shouldReceive('filter')->andReturn($give);
            $filter->addFilter($mocked);
        }

        $this->assertSame($expected, $filter->filter($file));
    }

    public function filteringProvider()
    {
        return array(
            array(array(true, false, true), true),
            array(array(false, false, false), false),
            array(array(true,true,true), true),
        );
    }



}
