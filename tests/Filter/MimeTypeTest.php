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
 * @since     11.11.14
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\FileFinderTest\Filter;

use Org_Heigl\FileFinder\Filter\MimeType;
use Mockery as M;

class MimeTypeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Org_Heigl\FileFinder\FileInfoInterface $finfo
     */
    protected $finfo;

    public function setup()
    {
        $this->finfo = M::mock('\Org_Heigl\FileFinder\Service\FinfoWrapper');
    }

    public function testSettingANdGettingMimeTypes()
    {
        $filter = new MimeType($this->finfo);

        $this->assertAttributeEquals(array(), 'mimeTypes', $filter);
        $this->assertSame($filter, $filter->addMimeType('image/jpeg'));
        $this->assertAttributeEquals(array('image/jpeg'), 'mimeTypes', $filter);
        $this->assertSame($filter, $filter->addMimeType('bar'));
        $this->assertAttributeEquals(array('image/jpeg', 'bar'), 'mimeTypes', $filter);

        $this->assertEquals(array('image/jpeg', 'bar'), $filter->getMimeTypes());
    }

    public function testInitializingWithExtensions()
    {
        $filter = new MimeType($this->finfo, array('image/jpeg', 'bar'));
        $this->assertAttributeEquals(array('image/jpeg', 'bar'), 'mimeTypes', $filter);
        $this->assertEquals(array('image/jpeg', 'bar'), $filter->getMimeTypes());
    }

    public function testInitializingWithSingleExtension()
    {
        $filter = new MimeType($this->finfo, 'image/jpeg');
        $this->assertAttributeEquals(array('image/jpeg'), 'mimeTypes', $filter);
        $this->assertEquals(array('image/jpeg'), $filter->getMimeTypes());
    }

    public function testFilterOne()
    {
        $filter = new MimeType($this->finfo, 'image/jpeg');
        $this->finfo->shouldReceive('getMimeType')->andReturn('image/jpeg');

        $fileInfo = M::mock('\SPLFileInfo');
        $fileInfo->shouldREceive('getPathname')->andReturn('foo');

        $this->assertTrue($filter->filter($fileInfo));
    }

    public function testFilterTwo()
    {
        $filter = new MimeType($this->finfo, array('image/jpeg', 'application/pdf'));
        $this->finfo->shouldReceive('getMimeType')->andReturn('application/pdf');

        $fileInfo = M::mock('\SPLFileInfo');
        $fileInfo->shouldREceive('getPathname')->andReturn('foo');

        $this->assertTrue($filter->filter($fileInfo));
    }

    public function testFilterThree()
    {
        $filter = new MimeType($this->finfo, 'image/jpeg');
        $this->finfo->shouldReceive('getMimeType')->andReturn('application/pdf');

        $fileInfo = M::mock('\SPLFileInfo');
        $fileInfo->shouldREceive('getPathname')->andReturn('bar');

        $this->assertFalse($filter->filter($fileInfo));
    }

}
