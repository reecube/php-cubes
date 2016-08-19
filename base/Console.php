<?php

namespace base {
    abstract class Console
    {

        /**
         * Will print the message with a new line.
         *
         * @param string $msg the message
         */
        public static function printLine($msg = '')
        {
            echo $msg . "\n";
        }

        /**
         * Will print the message with nice head decoration.
         *
         * @param string $msg the message
         */
        public static function printHead($msg)
        {
            $msg = '# ' . $msg . ' #';
            $hr = '';

            while (strlen($hr) < strlen($msg)) {
                $hr .= '#';
            }

            self::printLine($hr);
            self::printLine($msg);
            self::printLine($hr);
            self::printLine('');
        }

        /**
         * Will print the message as a new status line.
         *
         * @param string $status the status
         * @param string $msg the message
         */
        public static function printStatus($status, $msg)
        {
            self::printLine('[' . $status . '] ' . $msg);
        }
    }
}