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

namespace Org_Heigl\FileFinder;


class ClassMapList implements FileListInterface, \Countable
{
    use IteratorTrait;

    protected $list = array();

    /**
     * Add an SPL-File-Info to the filelist
     *
     * @param \SplFileInfo $file
     *
     * @return void
     */
    public function add(\SplFileInfo $file)
    {
        $content = new \Org_Heigl\FileFinder\Service\Tokenlist(file_get_contents($file->getPathname()));
        $classname = $content->getClassName();
        if (! $classname) {
            return;
        }

        $class = $content->getNamespace();
        $class[] = $classname;

        $key = str_replace('\\\\', '\\', '\\' . implode('\\', $class));

        $this->list[$key] = realpath($file->getPathname());
    }

    /**
     * Clear all entries from the filelist
     *
     * @return void
     */
    public function clear()
    {
        $this->list = array();
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     *
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     *       </p>
     *       <p>
     *       The return value is cast to an integer.
     */
    public function count()
    {
        return count($this->list);
    }

    /**
     * Get the content as array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->list;
    }

    /**
     * Get the array the iterator shall iterate over.
     *
     * @return mixed
     */
    protected function & getIteratorArray()
    {
        return $this->list;
    }
}
