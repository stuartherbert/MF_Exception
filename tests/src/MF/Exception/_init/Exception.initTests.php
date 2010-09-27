<?php

class Test_Exception_RootCause extends \Exception
{
        public function __construct()
        {
                parent::__construct('root cause', 1);
        }
}

class Test_Exception_Symptom extends \MF\Exception\EnterpriseException
{
        public function __construct()
        {
                parent::__construct(500, 1, "%s", array('symptom'), new Test_Exception_RootCause());
        }
}

?>
