<?php

namespace core\index {
    class Controller implements Gateway
    {

        public function sayHelloWorld()
        {
            echo 'Hello World';
        }
    }
}