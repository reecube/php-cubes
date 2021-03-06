<?php

namespace core\index {
    abstract class Cube implements \base\interfaces\Cube
    {
        const VERSION = '1.0.0';
        const DEPENDENCIES = array(
            'cubes' => array(),
            'core' => array(
                'base' => '1.x.x',
            ),
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