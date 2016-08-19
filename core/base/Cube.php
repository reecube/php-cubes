<?php

namespace core\base {
    abstract class Cube
    {
        const VERSION = '4.5.6';
        const DEPENDENCIES = array(
            'cubes' => array(),
            'core' => array(),
            'vendor' => array(),
        );

        /**
         * @return Gateway
         */
        public static function getGateway() {
            return new Controller();
        }
    }
}