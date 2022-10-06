<?php
require_once('orangtua.php');

class user extends orangtua
{
    public function __construct()
    {
        parent::__construct();
    }

    function __destruct()
    {
    }

    private function generate_salt() {
        return substr(date('dmYHis'), 4, 10);
    }

    private function encode_pass($password, $salt) {
        return sha1(sha1($password).$salt);
    }

    public function signup($nama, $username, $password)
    {
        $salt = $this->generate_salt();
        $encoded_pass = $this->encode_pass($password, $salt);
        $sql = "INSERT INTO users(name, username, password, salt) VALUES (?, ?, ?, ?)";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ssss", $nama, $username, $encoded_pass, $salt);
        $stmt->execute();

        return $stmt->affected_rows;
    }
}
