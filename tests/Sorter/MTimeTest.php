<?php
/**
 * Copyright (c) Andreas Heigl<andreas@heigl.org>
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
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author    Andreas Heigl<andreas@heigl.org>
 * @copyright Andreas Heigl
 * @license   http://www.opensource.org/licenses/mit-license.php MIT-License
 * @since     23.06.2017
 * @link      http://github.com/heiglandreas/org.heigl.FileFinder
 */

namespace Org_Heigl\FileFinderTest\Sorter;

use Org_Heigl\FileFinder\Sorter\MTime;
use SplFileInfo;

class MTimeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider mTimeSortingProvider
     */
    public function testThatMTimeSortingWorksAsExpected(
        SplFileInfo $first,
        SplFileInfo $second,
        $expected
    ) {
        $sorter = new MTime();
        $this->assertEquals($expected, $sorter($first, $second));
    }

    public function mTimeSortingProvider()
    {
        $date = new \DateTimeImmutable();
        touch(__DIR__ . '/../_assets/testFind/one.txt', $date->modify('-2 days')->getTimestamp());
        touch(__DIR__ . '/../_assets/testFind/two.php', $date->modify('-4 days')->getTimestamp());
        touch(__DIR__ . '/../_assets/testFind/three.txt', $date->getTimestamp());
        touch(__DIR__ . '/../_assets/testFind/four.php', $date->getTimestamp());
        return [[
            new SplFileInfo(__DIR__ . '/../_assets/testFind/one.txt'),
            new SplFileInfo(__DIR__ . '/../_assets/testFind/two.php'),
            -1
        ],[
            new SplFileInfo(__DIR__ . '/../_assets/testFind/two.php'),
            new SplFileInfo(__DIR__ . '/../_assets/testFind/one.txt'),
            1
        ],[
            new SplFileInfo(__DIR__ . '/../_assets/testFind/three.txt'),
            new SplFileInfo(__DIR__ . '/../_assets/testFind/four.php'),
            0
        ]];
    }
}
