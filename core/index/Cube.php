<?php

namespace core\index {
    abstract class Cube implements \core\ItfCube
    {
        const VERSION = '1.0.0';
        const DEPENDENCIES = array(
            'cubes' => array(
                'base' => '4.5.6',
            ),
            'core' => array(
                'base' => '4.5.6',
                'index' => '2.0.0',
            ),
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