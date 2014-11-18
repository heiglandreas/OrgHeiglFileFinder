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
 * @link      https://github.com/heiglandreas/OrgHeiglFileFinder
 */

namespace Org_Heigl\FileFinder\Filter;

use Org_Heigl\FileFinder\FilterInterface;

/**
 * Class HoldsSinglePHPClass
 *
 * THis class tests whether the file to filter holds a single PHP class or more.
 *
 * It returns ```true``` when only one class-statement is found and ```false```
 * when no or more than one class statement is found inside the file.
 *
 * There are no configuration options for this filter
 *
 * @package Org_Heigl\FileFinder\Filter
 */
class HoldsSinglePHPClass implements FilterInterface
{
    /**
     * Check whether the given file should be included in the final Filelist
     *
     * @param \SplFileInfo $file
     *
     * @return boolean
     */
    public function filter(\SplFileInfo $file)
    {
        $content = file_get_contents($file);
        $result = preg_match_all('/class\s+([^\s|\{]+)[\s\{]/im', $content, $results, PREG_PATTERN_ORDER);
        unset($content);

        if (!$result) {
            return false;
        }

        if (count($results[0]) > 1) {
            return false;
        }

        return true;
    }
}
