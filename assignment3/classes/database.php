<?php
    class MyDB {
        public $username;
        public $password;
        public $dbname;
        public $servername;

        function __construct($username, $password, $dbname, $servername) {
            $this->username = $username;
            $this->password = $password;
            $this->dbname = $dbname;
        }

        function set_username($username) {
            $this->username = $username;
        }

        function set_password($password) {
            $this->password = $password;
        }

        function set_dbname($dbname) {
            $this->dbname = $dbname;
        }

        function set_servername($servername) {
            $this->servername = $servername;
        }

        function get_username() {
            return $this->username;
        }

        function get_password() {
            return $this->password;
        }

        function get_dbname() {
            return $this->dbname;
        }

        function get_servername() {
            return $this->servername;
        }

    }
?>