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

use Mockery as M;
use Org_Heigl\FileFinder\Filter\FileSize;

class FileSizeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider settingFileSizesProvider
     */
    public function testSettingFileSizes($min, $max, $expectedMin, $expectedMax)
    {
        $filter = new FileSize();
        $this->assertAttributeEquals(null, 'minsize', $filter);
        $this->assertAttributeEquals(null, 'maxsize', $filter);

        $this->assertSame($filter, $filter->setMaxSize($max));
        $this->assertAttributeEquals($expectedMax, 'maxsize', $filter);

        $this->assertSame($filter, $filter->setMinSize($min));
        $this->assertAttributeEquals($expectedMin, 'minsize', $filter);

    }

    public function settingFileSizesProvider()
    {
        return array(
            array(null, 12, null, 12),
            array(12, null, 12, null),
            array('1k', '1kib', 1024, 1000),
            array('2M', '1MiB', 2097152, 1000000),
        );
    }

    /**
     * @dataProvider settingFileSizesProvider
     */
    public function testSettingFileSizesInConstructor($min, $max, $expectedMin, $expectedMax)
    {
        $filter = new FileSize($min, $max);

        $this->assertAttributeEquals($expectedMax, 'maxsize', $filter);
        $this->assertAttributeEquals($expectedMin, 'minsize', $filter);
    }

    /**
     * @@dataProvider determiningByteSizeProvider
     */
    public function testDeterminingByteSize($size, $realSize)
    {
        $obj = new FileSize();
        $method = \UnitTestHelper::getMethod($obj, 'getByteSize');
        $this->assertEquals($realSize, $method->invoke($obj, $size));
    }

    public function determiningByteSizeProvider()
    {
        return array(
            array(1,1),
            array('1k', 1024),
            array('1kb', 1024),
            array('1kib', 1000),
            array('1M', 1048576),
            array('1Mb', 1048576),
            array('1Mib', 1000000),
            array('1G', 1073741824),
            array('1Gb', 1073741824),
            array('1Gib', 1000000000),
            array('1T', 1099511627776),
            array('1Tb', 1099511627776),
            array('1Tib', 1000000000000),
        );
    }

    /**
     * @dataProvider filterProvider
     */
    public function testFilter($min, $max, $size, $result)
    {
        $filter = new FileSize($min, $max);

        $file = M::mock('\SPLFileInfo');
        $file->shouldReceive('getSize')->andReturn($size);

        $this->assertEquals($result, $filter->filter($file));
    }

    public function filterProvider()
    {
        return array(
            array(null, 12, 6, true),
            array(null, 12, 12, true),
            array(null, 12, 13, false),
            array(6, null, 5, false),
            array(6, null, 6, true),
            array(6, null, 7, true),
            array(6,12,5, false),
            array(6,12,6,true),
            array(6,12,7,true),
            array(6,12,12,true),
            array(6,12,13,false),
        );
    }


}
