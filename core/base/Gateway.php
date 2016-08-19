<?php

namespace core\base {
    interface Gateway extends \base\ItfGateway
    {
        public function sayHelloWorld();

        public function doTheBaseFnc();
    }
}