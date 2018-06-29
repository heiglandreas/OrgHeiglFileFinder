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

use Org_Heigl\FileFinder\Sorter\Size;
use PHPUnit\Framework\TestCase;
use SplFileInfo;
use Mockery as M;

class SizeTest extends TestCase
{
    /**
     * @dataProvider mTimeSortingProvider
     */
    public function testThatSizeSortingWorksAsExpected(
        SplFileInfo $first,
        SplFileInfo $second,
        $expected
    ) {
        $sorter = new Size();
        $this->assertEquals($expected, $sorter($first, $second));
    }

    public function mTimeSortingProvider()
    {

        $a = M::mock(SplFileInfo::class);
        $a->shouldReceive('getSize')->andReturn(1);

        $b = M::mock(SplFileInfo::class);
        $b->shouldReceive('getSize')->andReturn(2);

        return [
            [$a, $b, -1],
            [$b, $a, 1],
            [$b, $b, 0],
        ];
    }
}
