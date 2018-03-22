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

class ClassIsInstanceof implements FilterInterface
{
    protected $instances = array();

    /**
     * Check whether the given file should be included in the final Filelist
     *
     * @param \SplFileInfo $file
     *
     * @return boolean
     */
    public function filter(\SplFileInfo $file)
    {
        try {
            $class = $this->getClassName($file->getPathname());
        } catch (\Exception $e){
            return false;
        }

        if (! @include_once($file->getPathname())) {
            return false;
        }

        $ReflectionClass = new \ReflectionClass($class);

        if ($ReflectionClass->isAbstract()) {
            return false;
        }

        $class = $ReflectionClass->newInstanceWithoutConstructor();

        foreach ($this->instances as $instance) {
            if ($class instanceof $instance) {
                return true;
            }
        }

        return false;
    }

    protected function getClassName($file)
    {
        $content = new \Org_Heigl\FileFinder\Service\Tokenlist(file_get_contents($file));
        $class   = $content->getNamespace();

        $classname = $content->getClassName();
        if (! $classname) {
            throw new \InvalidArgumentException(sprintf(
                'The given file "%s" does not contain a class',
                $file
            ));
        }
        unset($content);

        $class[] = $classname;

        $classname = str_replace('\\\\', '\\', '\\' . implode('\\', $class));

        return $classname;
    }

    public function addInstance($instance)
    {
        $this->instances[] = $instance;

        return $this;
    }

    public function __construct($instances = array())
    {
        if (! is_array($instances)) {
            $instances = array($instances);
        }

        foreach($instances as $instance) {
            $this->addInstance($instance);
        }
    }
}
