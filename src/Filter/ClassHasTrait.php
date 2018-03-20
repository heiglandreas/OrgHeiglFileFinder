<?php
/**
 * Copyright (c)2014-2018 heiglandreas
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
 * @author    Michael Lämmlein<laemmi@spacerabbit.de>
 * @copyright ©2014-2018 Andreas Heigl
 * @license   http://www.opesource.org/licenses/mit-license.php MIT-License
 * @version   0.0
 * @since     20.03.18
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\FileFinder\Filter;

use SplFileInfo;
use Exception;

class ClassHasTrait extends ClassIsInstanceof
{
    protected $useautoload = true;

    /**
     * Set flag if use autoload in filter
     */
    public function setFlagUseAutoload(bool $value)
    {
        $this->useautoload = $value;
    }

    /**
     * Check whether the given file should be included in the final Filelist
     *
     * @param SplFileInfo $file
     *
     * @return boolean
     */
    public function filter(SplFileInfo $file)
    {
        try {
            $class = $this->getClassName($file->getPathname());
        } catch (Exception $e){
            return false;
        }

        $usedtraits = class_uses($class, $this->useautoload);

        foreach ($this->instances as $instance) {
            if (in_array($instance, $usedtraits)) {
                return true;
            }
        }

        return false;
    }
}