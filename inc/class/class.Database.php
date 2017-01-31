<?php

require_once "Settings.php";

class Database
{

    public static $affected_rows;
    public static $greska;
    private static $instance;
    public $test = false;
    private $connection;

    public function __construct()
    {

        try {
            $this->connection = new mysqli(HOST, USER, PASS, BASE);
            $this->connection->set_charset("utf8");

            if ($this->test) echo "Successful connected to Database!";

        } catch (Exception $e) {
            die ('Database connection failed: ' . $e->getTraceAsString());
        }
    }

    public function update($sql)
    {

        if ($this->test) echo $sql;
        $rs = 0;
        try {
            $rs = $this->connection->query($sql);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $rs;
    }

    public function query($sql)
    {

        if ($this->test) echo $sql;
        $rs = null;
        try {
            $rs = $this->connection->query($sql);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $rs;
    }

    public function getAffected()
    {

        return $this->connection->affected_rows;
    }

    public function getInsertId()
    {

        return $this->connection->insert_id;
    }

    public function getConnection()
    {

        if ($this->connection == null) self::getInstance();
        return $this->connection;
    }

    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new self();
        return self::$instance;
    }

    public function close()
    {

        $this->connection->close();
    }

    private function __clone()
    {
    }

}
