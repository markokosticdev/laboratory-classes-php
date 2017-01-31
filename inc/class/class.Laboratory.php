<?php

spl_autoload_register(function ($class) {
    require_once "class." . $class . ".php";
});

class Laboratory implements JsonSerializable
{

    private $laboratoryId;
    private $title;
    private $number;
    private $description;

    public function __construct($laboratoryId = null)
    {

        if (!is_null($laboratoryId)) {
            $this->laboratoryId = $laboratoryId;
        }
    }

    public static function isExist($laboratoryId)
    {

        $sql = "SELECT * FROM laboratory WHERE idLaboratory='{$laboratoryId}';";

        $result = Database::getInstance()->query($sql);
        if ($result->fetch_array() != false) return true;
        else return false;
    }

    public static function loadAll()
    {

        $sql = "SELECT * FROM laboratory;";

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            $i = 0;
            $laboratories = array();
            while ($row = $result->fetch_assoc()) {
                $laboratories[$i]["laboratoryId"] = $row["idLaboratory"];
                $laboratories[$i]["title"] = $row["title"];
                $laboratories[$i]["number"] = $row["number"];
                $laboratories[$i]["description"] = $row["description"];
                $i++;
            }
            return $laboratories;
        } else return false;
    }

    public static function loadSelected($laboratoryIds)
    {
        if (is_array($laboratoryIds)) {
            $laboratoryIdsIn = implode(",", $laboratoryIds);
            $sql = "SELECT * FROM laboratory WHERE idLaboratory IN ({$laboratoryIdsIn});";
        } elseif (!is_null($laboratoryIds)) {
            $sql = "SELECT * FROM laboratory WHERE idLaboratory='{$laboratoryIds}';";
        } else return false;

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            $i = 0;
            $laboratories = array();
            while ($row = $result->fetch_assoc()) {
                $laboratories[$i]["laboratoryId"] = $row["idLaboratory"];
                $laboratories[$i]["title"] = $row["title"];
                $laboratories[$i]["number"] = $row["number"];
                $laboratories[$i]["description"] = $row["description"];
                $i++;
            }
            return $laboratories;
        } else return false;
    }

    public static function toObject($array)
    {

        $object = new Laboratory();
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

    public static function add($title, $number, $description = null)
    {

        $description = (is_null($description)) ? NULL : $description;

        $sql = "INSERT INTO laboratory (idLaboratory,title,number,description)
VALUES (NULL, '{$title}', '{$number}','{$description}');";
        $result = Database::getInstance()->update($sql);

        if ($result) {
            return true;
        } else return false;

    }

    public static function update($laboratoryId, $title, $number, $description = null)
    {

        $description = (is_null($description)) ? NULL : $description;

        $sql = "UPDATE laboratory
                    SET title='{$title}', number='{$number}'";
        $sql .= ($description == NULL) ? "" : ", description='{$description}'";
        $sql .= "WHERE idLaboratory='{$laboratoryId}';";

        $result = Database::getInstance()->update($sql);

        if (!$result) return false;
        else return true;
    }

    public static function delete($laboratoryId)
    {

        $sql = "DELETE FROM laboratory WHERE idLaboratory='{$laboratoryId}'";
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

        if (property_exists("Laboratory", $this->$name))
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

        if (isset($this->laboratoryId)) {
            $sql = "SELECT * FROM laboratory WHERE idLaboratory='{$this->laboratoryId}';";
        } else return false;

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            while ($row = $result->fetch_assoc()) {
                $this->title = $row["title"];
                $this->number = $row["number"];
                $this->description = $row["description"];
            }
            return true;
        } else return false;
    }

}

