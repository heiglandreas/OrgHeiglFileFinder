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
use Org_Heigl\FileFinder\FileInfoInterface;

/**
 * Class MimeType
 *
 * This Class filters a filelist by the mimetype of a file.
 *
 * The given file has to be of one of the mimetypes added to this filter to be
 * included in the filelist.
 *
 * The mimetypes are retrieved using a ```\Finfo```-Object that has to be given
 * at creation of the ```MimeType```-Instance.
 *
 * Therefore an example for creating a MimeType-Filter would look like that:
 *
 * ```php
 * $finfo = new \Org_Heigl\FileFinder\Service\FinfoWrapper();
 * $filter = new MimeType($finfo);
 * $filter->addMimeType('application/pdf');
 * $filter->addMimeType('x-application/pdf');
 * $isPdf = $filter->filter('path/to/file.pdf');
 * ```
 *
 * @package Org_Heigl\FileFinder\Filter
 */
class MimeType implements FilterInterface
{

    /**
     * @var array $mimeTypes
     */
    protected $mimeTypes = array();

    /**
     * @var FileInfoInterface $finfo
     */
    protected $finfo = null;

    /**
     * Check whether the given file should be included in the final Filelist
     *
     * @param \SplFileInfo $file
     *
     * @return boolean
     */
    public function filter(\SplFileInfo $file)
    {
        return in_array($this->getMimeType($file), $this->mimeTypes);
    }

    /**
     * Create an instance of this filter
     *
     * @param Finfo $finfo
     * @param array $mimeTypes
     *
     * @return void
     */
    public function __construct(FileInfoInterface $finfo, $mimeTypes = array())
    {
        $this->finfo = $finfo;

        if (! is_array($mimeTypes)) {
            $mimeTypes = array($mimeTypes);
        }

        $this->setMimetypes($mimeTypes);
    }

    /**
     * @param array $mimeTypes
     *
     * @return self
     */
    public function setMimeTypes(array $mimeTypes)
    {
        $this->mimeTypes = $mimeTypes;

        return $this;
    }

    /**
     * Add a mimeType.
     *
     * @param string $mimeType
     *
     * @return self
     */
    public function addMimeType($mimeType)
    {
        $this->mimeTypes[] = $mimeType;

        return $this;
    }

    /**
     * get the mimetype-list
     *
     * @return array
     */
    public function getMimeTypes()
    {
        return $this->mimeTypes;
    }

    /**
     * Get the mimetype of a certain file
     *
     * @return string
     */
    public function getMimeType(\SplFileInfo $file)
    {
        return $this->finfo->getMimeType($file);
    }
}