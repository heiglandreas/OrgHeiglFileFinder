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
 * THis class tests whether the size of the file to filter is in a given range.
 *
 * The range can be set via the ```setMinSize()``` and ```setMaxSize()``` methods
 * as well as by providing appropriate statements to the constructor.
 *
 * Example:
 *
 * ```php
 * $filter = new FileSize($min, $max);
 * // equals to
 * $filter = new FileSize();
 * $filter->setMinSize($min)->setMaxSize($max);
 * ```
 *
 * @package Org_Heigl\FileFinder\Filter
 */
class FileSize implements FilterInterface
{

    /**
     * @var int $minsize
     */
    protected $minsize = null;

    /**
     * @var int $maxsize
     */
    protected $maxsize = null;

    /**
     * Check whether the given file should be included in the final Filelist
     *
     * @param \SplFileInfo $file
     *
     * @return boolean
     */
    public function filter(\SplFileInfo $file)
    {
        if ($this->minsize !== null && $this->minsize > $file->getSize()) {
            return false;
        }
        if ($this->maxsize !== null && $this->maxsize < $file->getSize()) {
            return false;
        }

        return true;
    }

    /**
     * Set the minimum filesize in Bytes
     *
     * @param int $size
     *
     * @return self
     */
    public function setMinSize($size)
    {
        $this->minsize = (int) $this->getByteSize($size);

        return $this;
    }

    /**
     * Set the maximum filesize in Bytes
     *
     * You can append 'MB', 'KB', 'GB' or 'TB'
     *
     * @param int $size
     *
     * @return $this
     */
    public function setMaxSize($size)
    {
        $this->maxsize = (int) $this->getByteSize($size);

        return $this;
    }

    /**
     * Calculate the correct size according to the appendix
     * @param string $size
     *
     * @return int
     */
    protected function getByteSize($size)
    {
        $mapping = array(
            'tib' => pow(1000, 4),
            'gib' => pow(1000, 3),
            'mib' => pow(1000, 2),
            'kib' => pow(1000, 1),
            'tb'  => pow(1024, 4),
            't'   => pow(1024, 4),
            'gb'  => pow(1024, 3),
            'g'   => pow(1024, 3),
            'mb'  => pow(1024, 2),
            'm'   => pow(1024, 2),
            'kb'  => pow(1024, 1),
            'k'   => pow(1024, 1),
        );
        if (! preg_match('/(\d+)\s*([tgkmbi]{1,3})/i', $size, $result)) {
            return $size;
        }

        return $mapping[strtolower($result[2])] * $result[1];
    }

    /**
     * Create an instance of the filter
     *
     * @param int $min
     * @param int $max
     */
    public function __construct($min = null, $max = null)
    {
        if (null !== $min) {
            $this->setMinSize($min);
        }

        if (null !== $max) {
            $this->setMaxSize($max);
        }
    }
}
