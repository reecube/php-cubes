<?php

namespace base {
    class Application
    {
        const PATHS = array(
            'core',
            'cubes',
        );

        /**
         * @var array $cubes
         */
        protected $cubes;

        /**
         * Will start the application.
         */
        public function start()
        {
            $this->initCubes();
        }

        /**
         * TODO
         *
         * @param string $path
         * @return array
         */
        protected function getDirectories($path)
        {
            return glob($path . '/*', GLOB_ONLYDIR);
        }

        /**
         * Will load all the cubes and check if there are any conflicts.
         */
        public function checkCubes()
        {
            $check = new Check();

            $check->checkCubes();
        }

        /**
         * Will load and initialize all the cubes.
         */
        public function initCubes()
        {
            $this->cubes = array();

            foreach (self::PATHS as $path) {
                foreach ($this->getDirectories($path) as $pathCube) {
                    $this->initCube($pathCube);
                }
            }
        }

        /**
         * TODO
         *
         * @param string $path
         */
        public function initCube($path)
        {
            $namespace = '\\' . str_replace('/', '\\', $path);

            /**
             * @var \core\index\Cube $Cube
             */
            $Cube = $namespace . '\\Cube';

            /**
             * @var string $classname
             */
            $classname = $Cube;

            /**
             * @var \base\interfaces\Gateway $gateway
             */
            $gateway = $Cube::getGateway();

            $gateway->init($this);

            $this->cubes[$classname] = $gateway;
        }

        /**
         * @param $path
         * @param $name
         * @return \base\interfaces\Gateway
         */
        public function getCube($path, $name)
        {
            $classname = '\\' . $path . '\\' . $name . '\\Cube';

            return isset($this->cubes[$classname]) ? $this->cubes[$classname] : null;
        }
    }
}