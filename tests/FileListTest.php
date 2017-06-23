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

namespace Org_Heigl\FileFinderTest;


use Org_Heigl\FileFinder\FileList;
use Mockery as M;

class FileListTest extends \PHPUnit_Framework_TestCase
{

    public function testADdingFile()
    {
        $filelist = new FileList();
        $file = M::mock('\SPLFileInfo');

        $this->assertAttributeEquals(array(), 'filelist', $filelist);
        $filelist->add($file);
        $this->assertAttributeEquals(array($file), 'filelist', $filelist);
        $filelist->clear();
        $this->assertAttributeEquals(array(), 'filelist', $filelist);
    }

    public function testCountableInterface()
    {
        $filelist = new FileList();
        $file = M::mock('\SPLFileInfo');

        $this->assertEquals(0, $filelist->count());
        $filelist->add($file);
        $this->assertEquals(1, $filelist->count());
        $filelist->add($file);
        $this->assertEquals(2, $filelist->count());
        $filelist->clear();
        $this->assertEquals(0, $filelist->count());
    }

    public function testIteratorInterface()
    {
        $filelist = new FileList();
        $file = M::mock('\SPLFileInfo');
        $file2 = M::mock('\SPLFileInfo');

        $filelist->add($file);
        $filelist->add($file2);

        $filelist->rewind();
        $this->assertEquals(0, $filelist->key());
        $this->assertTrue($filelist->valid());
        $this->assertEquals($file, $filelist->current());
        $filelist->next();
        $this->assertTrue($filelist->valid());
        $this->assertEquals(1, $filelist->key());
        $this->assertEquals($file2, $filelist->current());
        $filelist->next();
        $this->assertfalse($filelist->valid());
        $filelist->rewind();
        $this->assertTrue($filelist->valid());
        $this->assertEquals(0, $filelist->key());

    }

}
