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
use PHPUnit\Framework\TestCase;

class IntegrationTest extends TestCase
{
    public function testFindingPhpFiles()
    {
        $finder = new \Org_Heigl\FileFinder\FileFinder();
        $finder->addFilter(new \Org_Heigl\FileFinder\Filter\FileExtension('php'));
        $finder->addDirectory(__DIR__ . DIRECTORY_SEPARATOR . '_assets/testFind');
        $list = $finder->find();

        $this->assertInstanceOf('\Org_Heigl\FileFinder\FileList', $list);
        $this->assertEquals(2, $list->count());
        if (defined('HHVM_VERSION')) {
            $this->markTestIncomplete('Some parts skipped due to HHVM incompatibility');
            return;
        }
        $list->rewind();
        $this->assertEquals(new \SplFileInfo(__DIR__ . '/_assets/testFind/four.php'), $list->current());
        $list->next();
        $this->assertEquals(new \SplFileInfo(__DIR__ . '/_assets/testFind/two.php'), $list->current());
    }

    public function testClassMapping()
    {
        $this->markTestSkipped('Skipped due to a SegFault');
        $finder = new \Org_Heigl\FileFinder\FileFinder();
        $finder->addFilter(new \Org_Heigl\FileFinder\Filter\FileExtension('php'));
        $finder->addFilter(new \Org_Heigl\FileFinder\Filter\ClassIsInstanceof('\Org_Heigl\FileFinder\FilterInterface'));
        $finder->setFileList(new \Org_Heigl\FileFinder\ClassMapList());
        $finder->addDirectory(__DIR__ . '/../../../src');
        $list = $finder->find()->toArray();
        $this->assertArrayHasKey('\Org_Heigl\FileFinder\Filter\FileExtension', $list);
        $this->assertArrayNotHasKey('\Org_Heigl\FileFinder\ClassMapList', $list);
        $this->assertContains(realpath(__DIR__ . '/../../../src/Org_Heigl/FileFinder/Filter/FileExtension.php'), $list);
        $this->assertNotContains(realpath(__DIR__ . '/../../../src/Org_Heigl/FileFinder/ClasMapList.php'), $list);
    }
}
