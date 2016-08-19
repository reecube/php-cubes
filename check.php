<?php

require_once('autoload.php');

class Check
{
    const PATHS = array(
        'core',
        'cubes',
    );

    /**
     * @var array $dependencies
     */
    protected $dependencies;

    /**
     * @var array $cubes
     */
    protected $cubes;

    /**
     * Will print the message with a new line.
     *
     * @param string $msg the message
     */
    protected function printLine($msg = '')
    {
        echo $msg . "\n";
    }

    /**
     * Will print the message with nice head decoration.
     *
     * @param string $msg the message
     */
    protected function printHead($msg)
    {
        $msg = '# ' . $msg . ' #';
        $hr = '';

        while (strlen($hr) < strlen($msg)) {
            $hr .= '#';
        }

        $this->printLine($hr);
        $this->printLine($msg);
        $this->printLine($hr);
        $this->printLine('');
    }

    /**
     * Will print the message as a new status line.
     *
     * @param string $status the status
     * @param string $msg the message
     */
    protected function printStatus($status, $msg)
    {
        $this->printLine('[' . $status . '] ' . $msg);
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
        $this->printHead('This file will check the project configuration.');

        $this->dependencies = array();
        $this->cubes = array();

        $this->printStatus('info', 'Loading the cubes:');
        foreach (self::PATHS as $path) {
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
        $this->printLine();
        $this->printStatus('info', 'Looking for the dependencies:');

        $issues = 0;

        foreach ($this->dependencies as $Cube => $cubeDependencies) {
            foreach (self::PATHS as $path) {
                foreach ($cubeDependencies[$path] as $cdName => $cdVersion) {
                    $cdClass = '\\' . $path . '\\' . $cdName . '\\Cube';

                    if (isset($this->cubes[$cdClass])) {
                        $theVersion = $this->cubes[$cdClass];

                        if ($this->checkVersion($cdVersion, $theVersion)) {
                            $this->printStatus('valid', $cdClass . ' ' . $cdVersion);
                        } else {
                            $this->printStatus('invalid', 'The dependency "' . $cdClass . ' ' . $cdVersion . '" requested by "' . $Cube . '" does exist but has a wrong version!');
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

        $this->printLine();
        if ($issues <= 0) {
            $this->printStatus('success', 'The dependency-setup is valid.');
        } else {
            $this->printStatus('error', 'There are ' . $issues . ' issues in your dependency-setup!');
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
        $Cube = $namespace . '\\Cube';
        $this->dependencies[$Cube] = $Cube::DEPENDENCIES;
        $this->cubes[$Cube] = $Cube::VERSION;

        $this->printStatus('loaded', $Cube . ' ' . $Cube::VERSION);
    }

}

$check = new Check();

$check->checkCubes();

//$coreIndex = \core\index\Cube::getGateway();
//
//$coreIndex->sayHelloWorld();