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

namespace Org_Heigl\FileFinderTest\Service;

use Org_Heigl\FileFinder\Service\FinfoWrapper;
use Mockery as M;

class FinfoWrapperTest extends \PHPUnit_Framework_TestCase
{

    public function testInstantiationWithFInfo()
    {
        parent::markTestSkipped('Skipped');
        $finfo = $this->getMock('\finfo');
        $finfo->expects($this->once())
              ->method('set_flags')
              ->with($this->equalTo(FILEINFO_MIME_TYPE));

        $obj = new FinfoWrapper($finfo);
        $this->assertAttributeEquals($finfo, 'finfo', $obj);

    }

    public function testInstantiationWithoutFinfo()
    {
        $obj = new FinfoWrapper();
        $this->assertAttributeInstanceOf('\finfo', 'finfo', $obj);
    }

    public function testGettingMimetype()
    {
        parent::markTestSkipped('Skipped');
        $finfo = $this->getMock('\finfo');
        $finfo->expects($this->once())
              ->method('file')
              ->willReturn('foo');
        $finfo->expects($this->once())
            ->method('set_flags')
            ->with($this->equalTo(FILEINFO_MIME_TYPE));
        
        $file = M::mock('\SPLFileInfo');
        $file->shouldReceive('getPathname')->andReturn('bar');
        $obj = new FinfoWrapper($finfo);
        $this->assertSame('foo', $obj->getMimeType($file));
    }
}
