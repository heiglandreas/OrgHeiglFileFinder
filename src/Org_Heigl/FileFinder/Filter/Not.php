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
 * Class FileSize
 *
 * This class inverts the result of the contained filter
 *
 * You can set any ```FilterInterface``` either via the ```setFilter```-method
 * or by passing it to the constructor.
 *
 * Example:
 *
 * ```php
 * $filter = new Not(new MyFilter());
 * // equals to
 * $filter = new Not();
 * $filter->setFilter(new MyFilter());
 * ```
 *
 * @package Org_Heigl\FileFinder\Filter
 */
class Not implements FilterInterface
{

    /**
     * @var FilterInterface $filter
     */
    protected $filter = null;

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
        if (! $this->filter) {
            throw new \LogicException('No Filter has been set');
        }
        return ! $this->filter->filter($file);
    }

    /**
     * Set the filter to invert
     *
     * @param FilterInterface
     *
     * @return self
     */
    public function setFilter(FilterInterface $filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * Create an instance of the filter
     *
     * @param FilterInterface $filter
     */
    public function __construct(FilterInterface $filter = null)
    {
        if (null !== $filter) {
            $this->setFilter($filter);
        }
    }
}
