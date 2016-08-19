<?php

namespace core\index {
    class Controller implements Gateway
    {
        /**
         * @var \base\Application $app
         */
        protected $app;

        /**
         * @var \core\base\Gateway $cubeBase
         */
        protected $cubeBase;

        /**
         * @param \base\Application $app
         */
        public function init($app)
        {
            $this->app = $app;

            $this->cubeBase = $app->getCube('core', 'base');

            $this->cubeBase->doTheBaseFnc();
        }
    }
}