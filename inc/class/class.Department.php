<?php

spl_autoload_register(function ($class) {
    require_once "class." . $class . ".php";
});

class Department implements JsonSerializable
{

    private $departmentId;
    private $title;
    private $acronym;
    private $description;

    public function __construct($departmentId = null)
    {

        if (!is_null($departmentId)) {
            $this->departmentId = $departmentId;
        }
    }

    public static function isExist($departmentId)
    {

        $sql = "SELECT * FROM department WHERE idDepartment='{$departmentId}';";

        $result = Database::getInstance()->query($sql);
        if ($result->fetch_array() != false) return true;
        else return false;
    }

    public static function loadAll()
    {

        $sql = "SELECT * FROM department;";

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            $i = 0;
            $departments = array();
            while ($row = $result->fetch_assoc()) {
                $departments[$i]["departmentId"] = $row["idDepartment"];
                $departments[$i]["title"] = $row["title"];
                $departments[$i]["acronym"] = $row["acronym"];
                $departments[$i]["description"] = $row["description"];
                $i++;
            }
            return $departments;
        } else return false;
    }

    public static function loadSelected($departmentIds)
    {
        if (is_array($departmentIds)) {
            $departmentIdsIn = implode(",", $departmentIds);
            $sql = "SELECT * FROM department WHERE idDepartment IN ({$departmentIdsIn});";
        } elseif (!is_null($departmentIds)) {
            $sql = "SELECT * FROM department WHERE idDepartment='{$departmentIds}';";
        } else return false;

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            $i = 0;
            $departments = array();
            while ($row = $result->fetch_assoc()) {
                $departments[$i]["departmentId"] = $row["idDepartment"];
                $departments[$i]["title"] = $row["title"];
                $departments[$i]["acronym"] = $row["acronym"];
                $departments[$i]["description"] = $row["description"];
                $i++;
            }
            return $departments;
        } else return false;
    }

    public static function toObject($array)
    {

        $object = new Department();
        foreach ($array as $key => $value) {
            $object->$key = $value;
        }
    }

    public static function toObjectArray($array)
    {

        $newArray = array();
        $i = 0;
        foreach ($array as $val) {
            $newArray[$i++] = (object)$val;
        }
        return $newArray;
    }

    public static function add($title, $acronym, $description = null)
    {

        $description = (is_null($description)) ? NULL : $description;

        $sql = "INSERT INTO department (idDepartment,title,acronym,description)
VALUES (NULL, '{$title}', '{$acronym}','{$description}');";
        $result = Database::getInstance()->update($sql);

        if (!$result) return false;
        else return true;
    }

    public static function update($departmentId, $title, $acronym, $description = null)
    {

        $description = (is_null($description)) ? NULL : $description;

        $sql = "UPDATE department
                    SET title='{$title}', acronym='{$acronym}'";
        $sql .= ($description == NULL) ? "" : ", description='{$description}'";
        $sql .= "WHERE idDepartment='{$departmentId}';";

        $result = Database::getInstance()->update($sql);

        if (!$result) return false;
        else return true;
    }

    public static function delete($departmentId)
    {

        $sql = "DELETE FROM department WHERE idDepartment='{$departmentId}'";
        $result = Database::getInstance()->update($sql);

        if (!$result) return false;
        else return true;
    }

    public function __get($name)
    {

        return isset($this->$name) ? $this->$name : null;
    }

    public function __set($name, $value)
    {

        if (property_exists("Department", $this->$name))
            $this->$name = $value;
        else return null;
    }

    public function __clone()
    {
    }

    public function jsonSerialize()
    {

        return get_object_vars($this);
    }

    public function load()
    {

        if (isset($this->departmentId)) {
            $sql = "SELECT * FROM department WHERE idDepartment='{$this->departmentId}';";
        } else return false;

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            while ($row = $result->fetch_assoc()) {
                $this->title = $row["title"];
                $this->acronym = $row["acronym"];
                $this->description = $row["description"];
            }
            return true;
        } else return false;
    }

}