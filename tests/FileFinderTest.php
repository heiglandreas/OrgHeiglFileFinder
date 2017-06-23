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


use Org_Heigl\FileFinder\FileFinder;
use Mockery as M;
use Org_Heigl\FileFinder\FileList;

class FileFinderTest extends \PHPUnit_Framework_TestCase
{
    public function testAddingFilters()
    {
        $finder = new FileFinder();
        $filter = M::mock('Org_Heigl\FileFinder\FilterInterface');

        $this->assertAttributeEquals(array(), 'filterlist', $finder);
        $this->assertSame($finder, $finder->addFilter($filter));
        $this->assertAttributeEquals(array($filter), 'filterlist', $finder);
    }

    public function testAddingDirectories()
    {
        $finder = new FileFinder();
        $dir    = __DIR__ . '/_assets';

        $this->assertAttributeEquals(array(), 'searchLocations', $finder);
        $this->assertSame($finder, $finder->addDirectory($dir));
        $this->assertAttributeEquals(array($dir), 'searchLocations', $finder);
    }

    public function testSettingFileList()
    {
        $finder = new FileFinder();
        $filelist1 = new FileList();
        $filelist2 = M::mock('\Org_Heigl\FileFinder\FileListInterface');

        $this->assertAttributeEquals(null, 'fileList', $finder);
        $this->assertInstanceof('\Org_Heigl\FileFinder\FileList', $finder->getFileList());
        $this->assertAttributeEquals($filelist1, 'fileList', $finder);
        $this->assertSame($finder, $finder->setFileList($filelist2));
        $this->assertAttributeEquals($filelist2, 'fileList', $finder);
        $this->assertInstanceof('\Org_Heigl\FileFinder\FileListInterface', $finder->getFileList());
        $this->assertSame($filelist2, $finder->getFileList());
    }

    public function testFinding()
    {
        $finder = new FileFinder();
        $filelist = M::mock('\Org_Heigl\FileFinder\FileListInterface');
        $filelist->shouldReceive('clear')->once();
        $filelist->shouldReceive('add')->withAnyArgs();

        $dir1 = __DIR__ . DIRECTORY_SEPARATOR . '_assets' . DIRECTORY_SEPARATOR . 'testFind';
        $dir2 = __DIR__ . DIRECTORY_SEPARATOR . '_assets' . DIRECTORY_SEPARATOR . 'five.txt';

        $filter = M::mock('Org_Heigl\FileFinder\FilterInterface');
        $filter->shouldReceive('add');
        $filter->shouldReceive('filter')->andReturnValues(array(true, false, true, false));

        $finder->setFileList($filelist);

        $finder->addDirectory($dir1);
        $finder->addDirectory($dir2);

        $finder->addFilter($filter);

        $this->assertSame($filelist,$finder->find());



    }
}
