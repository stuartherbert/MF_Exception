<?php

namespace MF\Exception;

class InternalFaultExceptionTest extends EnterpriseExceptionTest
{
        public function setup ()
        {
                $this->fixture = new InternalFaultException(1, 'param 1: %s, param 2: %s', array ('array 1', 'array 2'));
                $this->type    = 'MF_Exception_Technical';
                $this->file    = basename(__FILE__);
                $this->line    = __LINE__ - 3;

                $rootCause = new \Test_Exception_RootCause();
                $this->fixtureWithRootCause = new InternalFaultException(1, 'param 1: %s, param 2: %s', array ('array 1', 'array 2'), $rootCause);

                $symptom = new \Test_Exception_Symptom();
                $this->fixtureWithSymptom = new InternalFaultException(1, 'param 1: %s, param 2: %s', array ('array 1', 'array 2'), $symptom);
        }

        public function testParent()
        {
                $this->assertTrue($this->fixture instanceof InternalFaultException);
        }
}
