<?php

namespace base {
    class Check
    {
        /**
         * @var array $dependencies
         */
        protected $dependencies;

        /**
         * @var array $cubes
         */
        protected $cubes;

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
            Console::printHead('This file will check the project configuration.');

            $this->dependencies = array();
            $this->cubes = array();

            Console::printStatus('info', 'Loading the cubes:');
            foreach (Application::PATHS as $path) {
                foreach ($this->getDirectories($path) as $pathCube) {
                    $this->loadCube($pathCube);
                }
            }

            // we need all the cubes and the dependencies in memory to check if the setup is valid
            $this->checkDependencies();
        }

        /**
         * TODO
         *
         * @param string $pattern
         * @param string $subject
         * @return bool
         */
        protected function checkVersion($pattern, $subject)
        {
            $result = true;

            $ap = explode('.', $pattern);
            $cp = count($ap);

            $as = explode('.', $subject);
            $cs = count($as);

            $min = $cp < $cs ? $cp : $cs;

            for ($i = 0; $i < $min; $i++) {
                if ($ap[$i] != $as[$i]) {
                    $tmpP = preg_replace('/[^0-9]/', '', $ap[$i]);
                    $tmpS = preg_replace('/[^0-9]/', '', $as[$i]);

                    if (strlen($tmpP) > 0 && $tmpP != $tmpS) {
                        $result = false;
                    }
                }
            }

            return $result;
        }

        /**
         * TODO
         */
        protected function checkDependencies()
        {
            Console::printLine();
            Console::printStatus('info', 'Looking for the dependencies:');

            $issues = 0;

            foreach ($this->dependencies as $Cube => $cubeDependencies) {
                foreach (Application::PATHS as $path) {
                    foreach ($cubeDependencies[$path] as $cdName => $cdVersion) {
                        $cdClass = '\\' . $path . '\\' . $cdName . '\\Cube';

                        if (isset($this->cubes[$cdClass])) {
                            $theVersion = $this->cubes[$cdClass];

                            if ($this->checkVersion($cdVersion, $theVersion)) {
                                Console::printStatus('valid', $cdClass . ' ' . $cdVersion);
                            } else {
                                Console::printStatus('invalid', 'The dependency "' . $cdClass . ' ' . $cdVersion . '" requested by "' . $Cube . '" does exist but has a wrong version!');
                                $issues++;
                            }
                        } else {
                            $this->printStatus('invalid', 'The dependency "' . $cdClass . ' ' . $cdVersion . '" requested by "' . $Cube . '" does not exist!');
                            $issues++;
                        }
                    }
                }

                // TODO: check for vendors with composer
            }

            Console::printLine();
            if ($issues <= 0) {
                Console::printStatus('success', 'The dependency-setup is valid.');
            } else {
                Console::printStatus('error', 'There are ' . $issues . ' issues in your dependency-setup!');
            }
        }

        /**
         * TODO
         *
         * @param string $path
         */
        public function loadCube($path)
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

            $this->dependencies[$classname] = $Cube::DEPENDENCIES;
            $this->cubes[$classname] = $Cube::VERSION;

            Console::printStatus('loaded', $Cube . ' ' . $Cube::VERSION);
        }
    }
}