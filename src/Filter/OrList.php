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

namespace Org_Heigl\FileFinder\Filter;

use Org_Heigl\FileFinder\FilterInterface;

/**
 * Class Or
 *
 * This class Returns true if at least one of the contained filters returned true
 *
 * You can set any ```FilterInterface``` either via the ```addFilter```-method
 * or by passing an array to the constructor.
 *
 * Example:
 *
 * ```php
 * $filter = new OrList(array(new MyFilter(), new MyAlternateFilter()));
 * // equals to
 * $filter = new OrList();
 * $filter->addFilter(new MyFilter());
 * $filter->addFilter(new MyAlternateFilter());
 * ```
 *
 * @package Org_Heigl\FileFinder\Filter
 */
class OrList implements FilterInterface
{

    /**
     * @var FilterInterface[] $filter
     */
    protected $filter = array();

    /**
     * Check whether the given file should be included in the final Filelist
     *
     * @param \SplFileInfo $file
     *
     * @throws LogicException
     * @return boolean
     */
    public function filter(\SplFileInfo $file)
    {
        foreach ($this->filter as $filter) {
            if ($filter->filter($file)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Add a filter to the list
     *
     * @param FilterInterface
     *
     * @return self
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->filter[] = $filter;

        return $this;
    }

    /**
     * Create an instance of the filter
     *
     * @param FilterInterface[] $filter
     */
    public function __construct(array $filter = array())
    {
        foreach ($filter as $item) {
            $this->addFilter($item);
        }
    }
}
