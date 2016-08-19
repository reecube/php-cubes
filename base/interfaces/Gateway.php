<?php

namespace base\interfaces {
    interface Gateway
    {
        /**
         * @param \base\Application $app
         */
        public function init($app);
    }
}