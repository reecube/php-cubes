<?php

namespace core\base {
    class Controller implements Gateway
    {

        public function sayHelloWorld()
        {
            \base\Console::printLine('Hello World from "base"');
        }

        public function doTheBaseFnc()
        {
            \base\Console::printLine('This is the base function!');
        }

        /**
         * @param \base\Application $app
         */
        public function init($app)
        {
            // TODO: Implement init() method.
        }
    }
}