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
 * @since     05.11.14
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\FileFinderTest\Filter;


use Org_Heigl\FileFinder\Filter\FileExtension;
use Mockery as M;
use PHPUnit\Framework\TestCase;

class FileExtensionTest extends TestCase
{
    public function testSettingANdGettingFileExtensions()
    {
        $filter = new FileExtension();

        $this->assertAttributeEquals(array(), 'extensions', $filter);
        $this->assertSame($filter, $filter->addExtension('foo'));
        $this->assertAttributeEquals(array('foo'), 'extensions', $filter);
        $this->assertSame($filter, $filter->addExtension('bar'));
        $this->assertAttributeEquals(array('foo', 'bar'), 'extensions', $filter);

        $this->assertEquals(array('foo', 'bar'), $filter->getExtensions());
    }

    public function testInitializingWithExtensions()
    {
        $filter = new FileExtension(array('foo', 'bar'));
        $this->assertAttributeEquals(array('foo', 'bar'), 'extensions', $filter);
        $this->assertEquals(array('foo', 'bar'), $filter->getExtensions());
    }

    public function testInitializingWithSingleExtension()
    {
        $filter = new FileExtension('foo');
        $this->assertAttributeEquals(array('foo'), 'extensions', $filter);
        $this->assertEquals(array('foo'), $filter->getExtensions());
    }

    public function testFilterOne()
    {
        $filter = new FileExtension('foo');

        $fileInfo = M::mock('\SPLFileInfo');
        $fileInfo->shouldREceive('getExtension')->andReturn('foo');

        $this->assertTrue($filter->filter($fileInfo));
    }

    public function testFilterTwo()
    {
        $filter = new FileExtension('foo', 'bar');

        $fileInfo = M::mock('\SPLFileInfo');
        $fileInfo->shouldREceive('getExtension')->andReturn('foo');

        $this->assertTrue($filter->filter($fileInfo));
    }

    public function testFilterThree()
    {
        $filter = new FileExtension('foo');

        $fileInfo = M::mock('\SPLFileInfo');
        $fileInfo->shouldREceive('getExtension')->andReturn('bar');

        $this->assertFalse($filter->filter($fileInfo));
    }

}
