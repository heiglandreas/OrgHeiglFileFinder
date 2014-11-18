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
 * @since     17.11.14
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\FileFinder\Service;


class Tokenlist 
{

    /**
     * @var array $tokenlist
     */
    protected $tokenlist;

    /**
     * Create a tokenlist based on the given string
     *
     * @param string $content
     */
    public function __construct($content)
    {
        $this->tokenlist = token_get_all($content);
    }

    /**
     * Get the first classname
     *
     * @return string
     */
    public function getClassName()
    {
        foreach ($this->tokenlist as $key => $token) {
            if (T_CLASS === $token[0]) {
                return $this->tokenlist[$key + 2][1];
            }
        }

        return '';
    }

    /**
     * Get the first namespace of the given content
     *
     * @return array
     */
    public function getNamespace()
    {
        $class       = array();
        $inNamespace = false;

        foreach ($this->tokenlist as $key => $token) {
            if (T_NAMESPACE === $token[0]) {
                $inNamespace = true;
                continue;
            }
            if (T_STRING === $token[0] && $inNamespace) {
                $class[] = $token[1];

            }
            if (';' === $token && $inNamespace) {
                return $class;
            }
        }

        return array();
    }
}