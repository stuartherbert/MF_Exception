<?php

/**
 * Methodosity Framework
 *
 * LICENSE
 *
 * Copyright (c) 2010 Stuart Herbert
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *  * Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 *  * Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in
 *    the documentation and/or other materials provided with the
 *    distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   MF
 * @package    MF_Exception
 * @copyright  Copyright (c) 2010 Stuart Herbert.
 * @license    http://www.opensource.org/licenses/bsd-license.php Simplified BSD License
 * @version    1.0
 * @link       http://framework.methodosity.com
 */

namespace MF\Exception;

/**
 * @category MF
 * @package  MF_Exception
 */

class ExceptionIterator implements \Iterator
{
        /**
         *
         * @var \MF\Exception\EnterpriseException
         */
        protected $start = null;

        /**
         *
         * @var \MF\Exception\EnterpriseException
         */
        private $current  = null;

        /**
         *
         * @var int
         */
        private $level    = 0;

        /**
         * Constructor.
         *
         * @param EnterpriseException $exception the first exception in
         *        the chain to iterate through
         */
        public function __construct(EnterpriseException $exception)
        {
                $this->start = $exception;
                $this->rewind();
        }

        // ---------------------------------------------------------------
        // Iterator support
        // ---------------------------------------------------------------

        public function rewind()
        {
                $this->current = $this->start;
                $this->level   = 0;
        }

        public function current()
        {
                return $this->current;
        }

        public function key()
        {
                return $this->level;
        }

        public function next()
        {
                // we can go no further if we're already off the end
                // of this list

                if ($this->current === null)
                {
                        return false;
                }

                // if we are at the end of the list, time to fall off
                // the end
                //
                // the last item in the list can be one of two types
                // of Exception:
                //
                // a) A generic PHP 5 Exception object, or
                // b) A framework Exception that has no cause data

                if ((!($this->current instanceof EnterpriseException)) ||
                    (!$this->current->hasCause()))
                {
                        $this->current = null;
                        $this->level++;
                        return false;
                }

                // if we get here, then we have not yet reached the end
                // of the list

                $this->current = $this->current->getCause();
                $this->level++;

                return true;
        }

        public function valid()
        {
                return ($this->current !== null);
        }
}
