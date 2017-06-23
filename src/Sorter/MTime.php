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

namespace Org_Heigl\FileFinder\Sorter;

use Org_Heigl\FileFinder\SorterInterface;
use SplFileInfo;

class MTime implements SorterInterface
{

    /**
     * A method that shall sort the first and second
     *
     * This method needs to return 1 if the second item is to be sorted after the
     * first, -1 if the second item is to be sorted before the first and 0 if
     * both are equal.
     **
     *
     * @param \SplFileInfo $first
     * @param \SplFileInfo $second
     *
     * @return int
     */
    public function __invoke(SPLFileInfo $first, SplFileInfo $second)
    {
        $diff = $first->getMTime() - $second->getMTime();
        if ($diff < 0) {
            return 1;
        }

        if ($diff > 0) {
            return -1;
        }

        return 0;
    }
}
