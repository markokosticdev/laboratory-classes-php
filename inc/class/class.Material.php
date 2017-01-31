<?php

spl_autoload_register(function ($class) {
    require_once "class." . $class . ".php";
});

class Material implements JsonSerializable
{

    private $materialId;
    private $title;
    private $file;
    private $location;
    private $extension;
    private $description;

    public function __construct($materialId = null)
    {
        if (!is_null($materialId)) {
            $this->materialId = $materialId;
        }
    }

    public static function isExist($materialId)
    {

        if (is_numeric($materialId)) {
            $sql = "SELECT * FROM material WHERE idMaterial='{$materialId}';";
        } else {
            $sql = "SELECT * FROM material WHERE title='{$materialId}';";
        }

        $result = Database::getInstance()->query($sql);
        if ($result->fetch_array() != false) return true;
        else return false;
    }

    public static function loadAll()
    {

        $sql = "SELECT * FROM material;";

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            $i = 0;
            $materials = array();
            while ($row = $result->fetch_assoc()) {
                $materials[$i]["materialId"] = $row["idMaterial"];
                $materials[$i]["title"] = $row["title"];
                $materials[$i]["file"] = $row["file"];
                $materials[$i]["location"] = $row["location"];
                $materials[$i]["extension"] = $row["extension"];
                $materials[$i]["description"] = $row["description"];
                $i++;
            }
            return $materials;
        } else return false;
    }

    public static function loadSelected($materialIds, $by = "material")
    {
        if (is_array($materialIds)) {
            $materialIdsIn = implode(",", $materialIds);
            $sql = "SELECT * FROM material WHERE idMaterial IN ({$materialIdsIn});";
        } elseif (is_numeric($materialIds) && $by == "material") {
            $sql = "SELECT * FROM material WHERE idMaterial='{$materialIds}';";
        } else if ($by == "exercise") {
            $sql = "SELECT * FROM material WHERE idExercise='{$materialIds}';";
        } else return false;

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            $i = 0;
            $materials = array();
            while ($row = $result->fetch_assoc()) {
                $materials[$i]["materialId"] = $row["idMaterial"];
                $materials[$i]["title"] = $row["title"];
                $materials[$i]["file"] = $row["file"];
                $materials[$i]["location"] = $row["location"];
                $materials[$i]["extension"] = $row["extension"];
                $materials[$i]["description"] = $row["description"];
                $i++;
            }
            return $materials;
        } else return false;
    }

    public static function toObject($array)
    {

        $object = new Material();
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

    public static function add($exercise, $title, $file, $location, $extension, $description = null)
    {

        $exerciseId = (is_numeric($exercise)) ? $exercise : $exercise->exerciseId;
        $description = (is_null($description)) ? 'NULL' : $description;

        $sql = "INSERT INTO material (idMaterial,idExercise,title,file,location,extension,description)
                    VALUES (NULL, '{$exerciseId}', '{$title}', '{$file}', '{$location}', '{$extension}', {$description});";
        $result = Database::getInstance()->update($sql);

        if (!$result) return false;
        else return true;
    }

    public static function update($materialId, $exercise, $title, $file, $location, $extension, $description = null)
    {

        $exerciseId = (is_numeric($exercise)) ? $exercise : $exercise->exerciseId;
        $description = (is_null($description)) ? 'NULL' : $description;

        $sql = "UPDATE material
                    SET idExercise='{$exerciseId}', 
                    title='{$title}', 
                    file='{$file}', 
                    location='{$location}', 
                    extension='{$extension}'";
        $sql .= ($description == 'NULL') ? "" : ", description='{$description}'";
        $sql .= "WHERE idMaterial='{$materialId}';";
        $result = Database::getInstance()->update($sql);

        if (!$result) return false;
        else return true;
    }

    public static function delete($materialId)
    {

        $sql = "DELETE FROM material WHERE idMaterial='{$materialId}'";
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

        if (property_exists("Material", $this->$name))
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

        if (isset($this->materialId)) {
            $sql = "SELECT * FROM material WHERE idMaterial='{$this->materialId}';";
        } else return false;

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            while ($row = $result->fetch_assoc()) {
                $this->title = $row["title"];
                $this->file = $row["file"];
                $this->location = $row["location"];
                $this->extension = $row["extension"];
                $this->description = $row["description"];
            }
            return true;
        } else return false;
    }

}

