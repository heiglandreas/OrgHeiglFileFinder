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

namespace Org_HeiglTest\FileFinder\Filter;


use Org_Heigl\FileFinder\Filter\FileStart;
use Mockery as M;

class FileStartTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider initializingProvider
     */
    public function testInitializing($content, $length, $expectedLength)
    {
        $filter = new FileStart($content, $length);
        $this->assertAttributeEquals($content, 'contains', $filter);
        $this->assertAttributeEquals($expectedLength, 'length', $filter);
    }

    public function initializingProvider()
    {
        return array(
            array('foo', 0, 3),
            array('blöd', 0, 4),
            array('test', 5, 5),
        );
    }

    /**
     * @dataProvider filterOneProvider
     */
    public function testFilterOne($contains, $length, $result)
    {
        $filter = new FileStart($contains, $length);
        $file = M::mock('\SPLFileInfo');
        $path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '_assets' . DIRECTORY_SEPARATOR . 'testFind' . DIRECTORY_SEPARATOR . 'one.txt';
        $file->shouldReceive('getPathname')->andReturn($path);

        $this->assertSame($result, $filter->filter($file));
    }

    public function filterOneProvider()
    {
        return array(
            array('foo', 0, false),
            array('Foo', 0,  true),
            array('Foo', 3, true),
            array('Foo', 4, true),
            array('ooB', 4, false),
            array('bar', 3, false),
        );
    }
}
