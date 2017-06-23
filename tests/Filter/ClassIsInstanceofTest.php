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

namespace Org_Heigl\FileFinderTest\Filter;


use Org_Heigl\FileFinder\Filter\ClassIsInstanceof;
use Mockery as M;

class ClassIsInstanceofTest extends \PHPUnit_Framework_TestCase
{
    public function testSettingInstances()
    {
        $filter = new ClassIsInstanceof();

        $this->assertAttributeEmpty('instances', $filter);
        $this->assertSame($filter, $filter->addInstance('Foo'));
        $this->assertAttributeEquals(array('Foo'), 'instances', $filter);
        $this->assertSame($filter, $filter->addInstance('Foo'));
        $this->assertAttributeEquals(array('Foo', 'Foo'), 'instances', $filter);
    }

    public function testSettingOneInstanceOnInstantiation()
    {
        $filter = new ClassIsInstanceof('Foo');
        $this->assertAttributeEquals(array('Foo'), 'instances', $filter);
    }

    public function testSettingMoreInstanceOnInstantiation()
    {
        $filter = new ClassIsInstanceof(array('Foo', 'Bar'));
        $this->assertAttributeEquals(array('Foo', 'Bar'), 'instances', $filter);
    }

    public function testGettingClassNameWithoutNamespace()
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '_assets' . DIRECTORY_SEPARATOR . 'testFind' . DIRECTORY_SEPARATOR . 'four.php';
        $obj = new ClassIsInstanceof();
        $method = \UnitTestHelper::getMethod($obj, 'getClassName');
        $result = $method->invoke($obj, $dir);

        $this->assertEquals('\Testclass', $result);
    }

    public function testGettingClassNameWithNamespace()
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '_assets' . DIRECTORY_SEPARATOR . 'testFind' . DIRECTORY_SEPARATOR . 'two.php';
        $obj = new ClassIsInstanceof();
        $method = \UnitTestHelper::getMethod($obj, 'getClassName');
        $result = $method->invoke($obj, $dir);

        $this->assertEquals('\TestSpace\Testclass', $result);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGettingClassNameWithoutClass()
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '_assets' . DIRECTORY_SEPARATOR . 'testFind' . DIRECTORY_SEPARATOR . 'one.txt';
        $obj = new ClassIsInstanceof();
        $method = \UnitTestHelper::getMethod($obj, 'getClassName');
        $method->invoke($obj, $dir);
    }

    public function testHasInterface()
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '_assets' . DIRECTORY_SEPARATOR . 'testFind' . DIRECTORY_SEPARATOR . 'two.php';
        $obj = new ClassIsInstanceof('\Iterator');

        $file = M::mock('\SPLFileInfo');
        $file->shouldReceive('getPathname')->andReturn($dir);

        $this->assertTrue($obj->filter($file));
    }

    public function testHasNotInterface()
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '_assets' . DIRECTORY_SEPARATOR . 'testFind' . DIRECTORY_SEPARATOR . 'four.php';
        $obj = new ClassIsInstanceof('\Iterator');

        $file = M::mock('\SPLFileInfo');
        $file->shouldReceive('getPathname')->andReturn($dir);

        $this->assertFalse($obj->filter($file));
    }

    public function testHasNotClassAtAll()
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '_assets' . DIRECTORY_SEPARATOR . 'testFind' . DIRECTORY_SEPARATOR . 'one.txt';
        $obj = new ClassIsInstanceof('\Iterator');

        $file = M::mock('\SPLFileInfo');
        $file->shouldReceive('getPathname')->andReturn($dir);

        $this->assertFalse($obj->filter($file));
    }

    public function testHasClassButCanNotLoad()
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '_assets' . DIRECTORY_SEPARATOR . 'testFind' . DIRECTORY_SEPARATOR . 'four.php';
        $obj = new ClassIsInstanceof('\Iterator');

        $file = M::mock('\SPLFileInfo');
        $file->shouldReceive('getPathname')->andReturnValues(array(
            $dir,
            $dir . '.txt',
        ));

        $this->assertFalse($obj->filter($file));
    }
}
