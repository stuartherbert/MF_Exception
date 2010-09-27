<?php

namespace MF\Exception;

class ProcessExceptionTest extends EnterpriseExceptionTest
{
        /**
         *
         * @var MF_Exception_Process
         */
        public $fixture;
        
        public function setup ()
        {
                $this->fixture = new ProcessException(404, 1, 'param 1: %s, param 2: %s', array ('array 1', 'array 2'));
                $this->type    = 'MF_Exception_Process';
                $this->file    = basename(__FILE__);
                $this->line    = __LINE__ - 3;

                $rootCause = new \Test_Exception_RootCause();
                $this->fixtureWithRootCause = new ProcessException(500, 1, 'param 1: %s, param 2: %s', array ('array 1', 'array 2'), $rootCause);

                $symptom = new \Test_Exception_Symptom();
                $this->fixtureWithSymptom = new ProcessException(500, 1, 'param 1: %s, param 2: %s', array ('array 1', 'array 2'), $symptom);
        }

        public function testParent()
        {
                $this->assertTrue($this->fixture instanceof ProcessException);
        }

        public function testCode()
        {
                $this->assertEquals(1, $this->fixture->getCode());
        }

        public function testCanGetHttpReturnCode()
        {
                $this->assertEquals(404, $this->fixture->getHttpCode());
        }
}
