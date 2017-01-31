<?php

spl_autoload_register(function ($class) {
    require_once "class." . $class . ".php";
});

class Exercise implements JsonSerializable
{

    private $exerciseId;
    private $title;
    private $number;
    private $description;
    private $materials = array();
    private $terms = array();

    public function __construct($exerciseId = null)
    {
        if (!is_null($exerciseId)) {
            $this->exerciseId = $exerciseId;
        }
    }

    public static function isExist($exerciseId)
    {

        if (is_numeric($exerciseId)) {
            $sql = "SELECT * FROM exercise WHERE idExercise='{$exerciseId}';";
        } else {
            $sql = "SELECT * FROM exercise WHERE title='{$exerciseId}';";
        }

        $result = Database::getInstance()->query($sql);
        if ($result->fetch_array() != false) return true;
        else return false;
    }

    public static function loadAll()
    {

        $sql = "SELECT * FROM exercise;";

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            $i = 0;
            $exercises = array();
            while ($row = $result->fetch_assoc()) {
                $exercises[$i]["exerciseId"] = $row["idExercise"];
                $exercises[$i]["title"] = $row["title"];
                $exercises[$i]["number"] = $row["number"];
                $exercises[$i]["description"] = $row["description"];
                $exercises[$i]["materials"] = Material::loadSelected($row["idExercise"], "exercise");
                $exercises[$i]["terms"] = Term::loadSelected($row["idExercise"], "exercise");
                $i++;
            }
            return $exercises;
        } else return false;
    }

    public static function loadSelected($exerciseIds, $by = "exercise")
    {
        if (is_array($exerciseIds)) {
            $exerciseIdsIn = implode(",", $exerciseIds);
            $sql = "SELECT * FROM exercise WHERE idExercise IN ({$exerciseIdsIn});";
        } elseif (is_numeric($exerciseIds) && $by == "exercise") {
            $sql = "SELECT * FROM exercise WHERE idExercise='{$exerciseIds}';";
        } else if ($by == "subject") {
            $sql = "SELECT * FROM exercise WHERE idSubject='{$exerciseIds}';";
        } else return false;

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            $i = 0;
            $exercises = array();
            while ($row = $result->fetch_assoc()) {
                $exercises[$i]["exerciseId"] = $row["idExercise"];
                $exercises[$i]["title"] = $row["title"];
                $exercises[$i]["number"] = $row["number"];
                $exercises[$i]["description"] = $row["description"];
                $exercises[$i]["materials"] = Material::loadSelected($row["idExercise"], "exercise");
                $exercises[$i]["terms"] = Term::loadSelected($row["idExercise"], "exercise");
                $i++;
            }
            return $exercises;
        } else return false;
    }

    public static function loadAssistants($exerciseId)
    {

        $sql = "SELECT * FROM exercise_assistant WHERE idExercise='{$exerciseId}';";

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            $i = 0;
            $assistants = array();
            while ($row = $result->fetch_assoc()) {
                $assistants[$i] = new Assistant($row["idUser"]);
                $assistants[$i]->load();
                $i++;
            }
            return $assistants;
        } else return false;
    }

    public static function loadSubject($exerciseId)
    {

        $sql = "SELECT * FROM exercise WHERE idExercise='{$exerciseId}';";

        $result = Database::getInstance()->query($sql);
        if ($result != false) {

            $row = $result->fetch_assoc();
            $subject = new Subject($row["idSubject"]);
            $subject->load();

            return $subject;
        } else return false;
    }

    public static function toObject($array)
    {

        $object = new Exercise();
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

    public static function add($subject, $title, $number, $description = null, $materials = null)
    {

        $subjectId = (is_numeric($subject)) ? $subject : $subject->subjectId;
        $description = (is_null($description)) ? NULL : $description;
        $materials = (is_null($materials)) ? 'NULL' : $materials;

        $sql = "INSERT INTO exercise (idExercise,idSubject,title,number,description)
                    VALUES (NULL, '{$subjectId}', '{$title}', '{$number}', '{$description}');";
        $result = Database::getInstance()->update($sql);
        if (!$result) return false;

        $exerciseId = Database::getInstance()->getInsertId();

        foreach ($materials as $val) {
            if (!Material::add($exerciseId, $val->title, $val->file, $val->location, $val->extension, $val->description)) return false;
        }

        return true;
    }

    public static function update($exerciseId, $subject, $title, $number, $description = null, $materials = null)
    {

        $subjectId = (is_numeric($subject)) ? $subject : $subject->subjectId;
        $description = (is_null($description)) ? 'NULL' : $description;
        $materials = (is_null($materials)) ? null : $materials;

        $sql = "UPDATE exercise
                    SET  idSubject='{$subjectId}',
                    title='{$title}',
                    number='{$number}'";
        $sql .= ($description == 'NULL') ? "" : ", description='{$description}'";
        $sql .= "WHERE idExercise='{$exerciseId}';";
        $result = Database::getInstance()->update($sql);
        if (!$result) return false;

        $sql = "DELETE FROM material WHERE idExercise='{$exerciseId}'";
        $result = Database::getInstance()->update($sql);
        if (!$result) return false;

        foreach ($materials as $val) {
            if (!Material::add($exerciseId, $val->title, $val->file, $val->location, $val->extension, $val->description)) return false;
        }

        return true;
    }

    public static function delete($exerciseId)
    {

        $sql = "DELETE FROM exercise WHERE idExercise='{$exerciseId}'";
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

        if (property_exists("Exercise", $this->$name))
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

        if (isset($this->exerciseId)) {
            $sql = "SELECT * FROM exercise WHERE idExercise='{$this->exerciseId}';";
        } else return false;

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            while ($row = $result->fetch_assoc()) {
                $this->title = $row["title"];
                $this->number = $row["number"];
                $this->description = $row["description"];
                $this->materials = Material::loadSelected($this->exerciseId, "exercise");
                $this->terms = Term::loadSelected($this->exerciseId, "exercise");
            }
            return true;
        } else return false;
    }

}

