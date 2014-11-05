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

namespace Org_Heigl\FileFinder;


class FileFinder 
{

    /**
     * @var array $filterlist
     */
    protected $filterlist = array();

    /**
     * @var array $searchLocation
     */
    protected $searchLocations = array();

    /**
     * @var FileListInterface $fileList
     */
    protected $fileList = null;

    /**
     * Add a further filter
     *
     * @param FilterInterface $filter
     *
     * @return self
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->filterlist[] = $filter;

        return $this;
    }

    /**
     * Add a further directory to search for files in
     *
     * @param string $dir
     *
     * @return self
     */
    public function addDirectory($dir)
    {
        $this->searchLocations[] = $dir;

        return $this;
    }

    /**
     * Set the file list
     *
     * @param FileListInterface $fileList
     *
     * @return self
     */
    public function setFileList(FileListInterface $fileList)
    {
        $this->fileList = $fileList;

        return $this;
    }

    /**
     * Get the file list
     *
     * @return FileListInterface
     */
    public function getFileList()
    {
        if (! $this->fileList instanceof FileListInterface) {
            $this->fileList = new FileList();
        }
        return $this->fileList;
    }

    /**
     * Do the actual searching
     *
     * @return FileListInterface[]
     */
    public function find()
    {
        $this->fileList->clear();
        foreach ($this->searchLocations as $location) {
            if (! is_dir($location)) {
                continue;
            }
            $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($location));
            foreach ($iterator as $file) {
                if (! $this->filter($file)) {
                    continue;
                }
                $this->fileList->add($file);
            }
        }

        return $this->fileList;
    }

    /**
     * Filter the file
     *
     * @param SPLFileInfo $file
     *
     * @return bool
     */
    public function filter(\SPLFileInfo $file)
    {
        foreach ($this->filterlist as $filter) {
            if (! $filter->filter($file)) {
                return false;
            }
        }
        return true;
    }
}