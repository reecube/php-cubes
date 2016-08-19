<?php

namespace core\base {
    abstract class Cube implements \core\ItfCube
    {
        const VERSION = '1.0.0';
        const DEPENDENCIES = array(
            'cubes' => array(),
            'core' => array(),
            'vendor' => array(),
        );

        /**
         * @return Gateway
         */
        public static function getGateway()
        {
            return new Controller();
        }
    }
}