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

class EnterpriseException extends \Exception
{
        /**
         * holds the original exception if we are throwing a new one
         *
         * @var Exception
         */
        protected $cause = null;

        /**
         * holds the list of parameters to explain this exception
         *
         * @var array
         */
        protected $params = null;

        /**
         * the HTTP code to return to the browser or calling HTTP client
         *
         * @var int
         */
        protected $httpCode = 500;

        /**
         * the enterprise error code to write into log files
         *
         * @var string
         */
        protected $errCode = '';

        /**
         * constructor
         */

        public function __construct ($httpCode, $errorCode, $formatString, $params, \Exception $cause = null)
        {
                $message = vsprintf($formatString, $params);

                parent::__construct($message, 1);

                // we keep our own copy of this because the underlying
                // PHP exception insists that error codes can only be
                // numeric ... grrr
                $this->errCode   = $errorCode;

                // we keep our own copies of this because the underlying
                // PHP exception insists on keeping them private, which
                // is both dumb and inconvenient
                $this->cause     = $cause;

                // we keep the params separate so that they can be dumped
                // for automatic analysis and reporting
                $this->params    = $params;

                // we want to keep HTTP status codes separate from the
                // numerical ID for each unique reportable error
                $this->httpCode  = $httpCode;
        }

        /**
         * return the exception that caused this exception
         */

        public function getCause()
        {
                return $this->cause;
        }

        /**
         * was this exception caused by another one?
         */

        public function hasCause()
        {
                if ($this->cause != null)
                        return true;

                return false;
        }

        /**
         *
         * @param string $cause name of the class to check for
         * @return boolean
         */
        public function wasCausedBy($cause)
        {
                // if we have no cause, bail
        	if (!$this->hasCause())
                {
                	return false;
                }

                // if the cause matches, let them know
                if ($this->cause instanceof $cause)
                {
                	return true;
                }

                // what if the cause is also a symptom?
                if (method_exists($this->cause, 'wasCausedBy'))
                {
                        return $this->cause->wasCausedBy($cause);
                }

                // if we get here, we have exhausted our possibilities
                return false;
        }

        /**
         * Get an iterator to explore any chained causes
         *
         * @return \MF_Exception_Iterator an object to iterate through
         *         all of the chained causes
         */
        public function getIterator ()
        {
                return new ExceptionIterator($this);
        }

        /**
         * Get the list of parameters passed into the formatString
         *
         * @return array a list of the params, indexed numerically
         */
        public function getParams()
        {
                return $this->params;
        }

        /**
         * Get the HTTP status code to report back to the browser
         *
         * @return int The HTTP status code set by this exception
         */
        public function getHttpCode()
        {
                return $this->httpCode;
        }
}

?>