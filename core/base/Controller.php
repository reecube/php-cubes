<?php

namespace core\base {
    class Controller implements Gateway
    {

        public function sayHelloWorld()
        {
            echo 'Hello World from "base"';
        }

        public function doTheBaseFnc()
        {
            echo 'This is the base function!';
        }

        public function init()
        {
            // TODO: Implement init() method.
        }
    }
}