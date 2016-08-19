<?php

namespace core\base {
    abstract class Cube implements \core\ItfCube
    {
        const VERSION = '4.5.6';
        const DEPENDENCIES = array(
            'cubes' => array(),
            'core' => array(
                'index' => '1.x.x',
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