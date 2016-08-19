<?php

namespace core\base {
    interface Gateway extends \base\interfaces\Gateway
    {
        public function sayHelloWorld();

        public function doTheBaseFnc();
    }
}