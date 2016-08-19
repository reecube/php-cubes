<?php

namespace core\base {
    class Controller implements Gateway
    {

        public function sayHelloWorld()
        {
            echo 'Hello World';
        }

        public function doTheBaseFnc()
        {
            echo 'This is the base function!';
        }
    }
}