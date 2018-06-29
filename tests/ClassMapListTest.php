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
 * @since     06.11.14
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\FileFinderTest;


use Org_Heigl\FileFinder\ClassMapList;
use Mockery as M;
use PHPUnit\Framework\TestCase;

class ClassMapListTest extends TestCase
{
    public function testADdingFile()
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR . '_assets' . DIRECTORY_SEPARATOR . 'testFind' . DIRECTORY_SEPARATOR . 'four.php';
        $filelist = new ClassMapList();
        $file = M::mock('\SPLFileInfo');
        $file->shouldReceive('getPathname')->twice()->andReturn($dir);

        $this->assertAttributeEquals(array(), 'list', $filelist);
        $filelist->add($file);
        $this->assertAttributeEquals(array('\Testclass' => $dir), 'list', $filelist);
        $filelist->clear();
        $this->assertAttributeEquals(array(), 'list', $filelist);
    }

    public function testCountableInterface()
    {
        $dir1 = __DIR__ . DIRECTORY_SEPARATOR . '_assets' . DIRECTORY_SEPARATOR . 'testFind' . DIRECTORY_SEPARATOR . 'four.php';
        $dir2 = __DIR__ . DIRECTORY_SEPARATOR . '_assets' . DIRECTORY_SEPARATOR . 'testFind' . DIRECTORY_SEPARATOR . 'two.php';

        $filelist = new ClassMapList();
        $file = M::mock('\SPLFileInfo');
        $file->shouldReceive('getPathname')->andReturnValues(array(
            $dir1,
            $dir1,
            $dir2,
            $dir2,
        ));

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
        $dir1 = __DIR__ . DIRECTORY_SEPARATOR . '_assets' . DIRECTORY_SEPARATOR . 'testFind' . DIRECTORY_SEPARATOR . 'four.php';
        $dir2 = __DIR__ . DIRECTORY_SEPARATOR . '_assets' . DIRECTORY_SEPARATOR . 'testFind' . DIRECTORY_SEPARATOR . 'two.php';
        $dir3 = __DIR__ . DIRECTORY_SEPARATOR . '_assets' . DIRECTORY_SEPARATOR . 'testFind' . DIRECTORY_SEPARATOR . 'one.txt';

        $filelist = new ClassMapList();
        $file = M::mock('\SPLFileInfo');
        $file->shouldReceive('getPathname')->andReturnValues(array(
            $dir1,
            $dir1,
            $dir2,
            $dir2,
            $dir3,
        ));
        $filelist->add($file);
        $filelist->add($file);
        $filelist->add($file);

        $filelist->rewind();
        $this->assertEquals('\Testclass', $filelist->key());
        $this->assertTrue($filelist->valid());
        $this->assertEquals($dir1, $filelist->current());
        $filelist->next();
        $this->assertTrue($filelist->valid());
        $this->assertEquals('\TestSpace\Testclass', $filelist->key());
        $this->assertEquals($dir2, $filelist->current());
        $filelist->next();
        $this->assertfalse($filelist->valid());
        $filelist->rewind();
        $this->assertTrue($filelist->valid());
        $this->assertEquals('\Testclass', $filelist->key());

    }

    public function testGettingArray()
    {
        $filelist = new ClassMapList();
        $this->assertEquals(array(), $filelist->toArray());
    }
}
