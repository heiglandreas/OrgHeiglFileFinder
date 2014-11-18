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

namespace Org_Heigl\FileFinder\Filter;


use Org_Heigl\FileFinder\FilterInterface;

/**
 * Class DateCompare
 *
 * Compare a file with a given date.
 *
 * This filter checks whether a file has a certain relation to a given date. The
 * relation can be *before*, *equals* or *after*. By default checks are performed
 * for equality.
 *
 * By default the date of the last change of the files content (mtime) is checked,
 * but it is also possible to check for the date of the last access to the file
 * (atime) or the last change of the files metadata (changes to the inode - ctime).
 *
 * @package Org_Heigl\FileFinder\Filter
 */
class DateCompare implements FilterInterface
{

    /**
     * Check against the date of the **last change of the content** of a file
     */
    const DATE_M = 'MTime';

    /**
     * Check against the date of the **last change of the metadata** of a file
     */
    const DATE_C = 'CTime';

    /**
     * Check against the date of the **last access** of the file
     */
    const DATE_A = 'ATime';

    /**
     * Check for equality
     */
    const CHECK_EQUAL = 1;

    /**
     * Check whether the files date is **before** the reference date
     */
    const CHECK_BEFORE = 2;

    /**
     * Check whether the files date is **after** the reference date
     */
    const CHECK_AFTER = 3;

    /**
     * @var \DateTime $compareDate
     */
    protected $compareDate = null;

    /**
     * @var string $compareType
     */
    protected $compareType = null;

    /**
     * @var int compareAction
     */
    protected $compareAction = null;

    /**
     * Create an instance of the comparator
     *
     * @param DateTime $compareDate
     * @param string   $compareType
     * @param int      $compareAction
     *
     * @return void
     */
    public function __construct(\DateTimeInterface $compareDate, $compareType = self::DATE_M, $compareAction = self::CHECK_EQUAL)
    {
        if (! in_array($compareType, array(self::DATE_M, self::DATE_A, self::DATE_C))) {
            throw new \InvalidArgumentException(sprintf(
                'The given compareType does not match the requirements'
            ));
        }
        $this->compareDate = $compareDate;
        $this->compareType = $compareType;
        $this->compareAction = $compareAction;
    }

    /**
     * Check whether the given file should be included in the final Filelist
     *
     * @param \SplFileInfo $file
     *
     * @return boolean
     */
    public function filter(\SplFileInfo $file)
    {
        $filedate = new \DateTime('@' . $file->{'get' . $this->compareType}());

        $diff = $this->compareDate->diff($filedate);
        $diffSign = $diff->format('%R');

        if ((int) $diff->format('%y%m%d%h%i%s') == 0 && $this->compareAction == self::CHECK_EQUAL) {
            return true;
        }
        if ($diffSign == '-' && $this->compareAction == self::CHECK_BEFORE) {
            return true;
        }
        if ($diffSign == '+' && $this->compareAction == self::CHECK_AFTER) {
            return true;
        }

        return false;
    }
}
