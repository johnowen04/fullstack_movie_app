<?php

    class coba {
        private $var = "nilai default";
        private $var2;

        public function __construct() {
            $this->var = "nilainya diubah";
            echo "Constructed ".$this->var."<br>";
        }

        public function displayData() {
            echo $this->var;
        }

        function setValue($newValue) {
            $this->var = $newValue;
        }

        function __destruct() {
            echo "Destroying ".$this->var."<br>";
        }
    }

?>