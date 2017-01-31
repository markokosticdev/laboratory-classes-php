<?php

spl_autoload_register(function ($class) {
    require_once "class." . $class . ".php";
});

class Subject implements JsonSerializable
{

    private $subjectId;
    private $title;
    private $description;
    private $departments = array();
    private $assistants = array();
    private $exercises = array();


    public function __construct($subjectId = null)
    {

        if (!is_null($subjectId)) {
            $this->subjectId = $subjectId;
        }
    }

    public static function isExist($subjectId)
    {

        if (is_numeric($subjectId)) {
            $sql = "SELECT * FROM subject WHERE idSubject='{$subjectId}';";
        } else {
            $sql = "SELECT * FROM subject WHERE title='{$subjectId}';";
        }

        $result = Database::getInstance()->query($sql);
        if ($result->fetch_array() != false) return true;
        else return false;
    }

    public static function loadAll()
    {

        $sql = "SELECT * FROM subject;";

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            $i = 0;
            $subjects = array();
            while ($row = $result->fetch_assoc()) {
                $subjects[$i]["subjectId"] = $row["idSubject"];
                $subjects[$i]["title"] = $row["title"];
                $subjects[$i]["description"] = $row["description"];
                $subjects[$i]["departments"] = Subject::loadDepartments($row["idSubject"]);
                $subjects[$i]["assistants"] = Subject::loadAssistants($row["idSubject"]);
                $subjects[$i]["exercises"] = Subject::loadExercises($row["idSubject"]);
                $i++;
            }
            return $subjects;
        } else return false;
    }

    public static function loadSelected($subjectIds)
    {
        if (is_array($subjectIds)) {
            $departmentIdsIn = implode(",", $subjectIds);
            $sql = "SELECT * FROM subject WHERE idSubject IN ({$departmentIdsIn});";
        } elseif (!is_null($subjectIds)) {
            $sql = "SELECT * FROM subject WHERE idSubject='{$subjectIds}';";
        } else return false;

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            $i = 0;
            $subjects = array();
            while ($row = $result->fetch_assoc()) {
                $subjects[$i]["subjectId"] = $row["idSubject"];
                $subjects[$i]["title"] = $row["title"];
                $subjects[$i]["description"] = $row["description"];
                $subjects[$i]["departments"] = Subject::loadDepartments($row["idSubject"]);
                $subjects[$i]["assistants"] = Subject::loadAssistants($row["idSubject"]);
                $subjects[$i]["exercises"] = Subject::loadExercises($row["idSubject"]);
                $i++;
            }
            return $subjects;
        } else return false;
    }

    public static function toObject($array)
    {

        $object = new Subject();
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

    public static function add($title, $departments, $assistants, $description = null, $year = null, $semester = null)
    {

        $description = (is_null($description)) ? 'NULL' : $description;
        $year = (is_null($year)) ? 'NULL' : $year;
        $semester = (is_null($semester)) ? 'NULL' : $semester;

        $sql = "INSERT INTO subject (idSubject,title,description)
                    VALUES (NULL, '{$title}', '{$description}');";
        $result = Database::getInstance()->update($sql);
        if (!$result) return false;

        $subjectId = Database::getInstance()->getInsertId();

        foreach ($departments as $val) {
            $sql = "INSERT INTO subject_department (idSubject,idDepartment,year,semester)
                            VALUES ('{$subjectId}', '{$val->departmentId}', {$year}, {$semester});";
            $result = Database::getInstance()->update($sql);
            if (!$result) return false;
        }

        foreach ($assistants as $val) {
            $sql = "INSERT INTO subject_assistant (idUser,idSubject)
                            VALUES ('{$val->userId}', '{$subjectId}');";
            $result = Database::getInstance()->update($sql);
            if (!$result) return false;
        }

        return true;
    }

    public static function update($subjectId, $title, $departments, $assistants, $description = null, $year = null, $semester = null)
    {

        $description = (is_null($description)) ? 'NULL' : $description;
        $year = (is_null($year)) ? 'NULL' : $year;
        $semester = (is_null($semester)) ? 'NULL' : $semester;

        $sql = "UPDATE subject
                    SET title='{$title}'";
        $sql .= ($description == 'NULL') ? "" : ", description='{$description}'";
        $sql .= "WHERE idSubject='{$subjectId}';";
        $result = Database::getInstance()->update($sql);
        if (!$result) return false;

        $sql = "DELETE FROM subject_department WHERE idSubject='{$subjectId}'";
        $result = Database::getInstance()->update($sql);
        if (!$result) return false;

        $sql = "DELETE FROM subject_assistant WHERE idSubject='{$subjectId}'";
        $result = Database::getInstance()->update($sql);
        if (!$result) return false;

        foreach ($departments as $val) {
            $sql = "INSERT INTO subject_department (idSubject,idDepartment,year,semester)
                        VALUES ('{$subjectId}', '{$val->departmentId}', {$year}, {$semester});";
            $result = Database::getInstance()->update($sql);
            if (!$result) return false;
        }

        foreach ($assistants as $val) {
            $sql = "INSERT INTO subject_assistant (idUser,idSubject)
                        VALUES ('{$val->userId}', '{$subjectId}');";
            $result = Database::getInstance()->update($sql);
            if (!$result) return false;
        }

        return true;
    }

    public static function delete($subjectId)
    {

        $sql = "DELETE FROM subject WHERE idSubject='{$subjectId}'";
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

        if (property_exists("Subject", $this->$name))
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

        if (isset($this->subjectId)) {
            $sql = "SELECT * FROM subject WHERE idSubject='{$this->subjectId}';";
        } else return false;

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            while ($row = $result->fetch_assoc()) {
                $this->title = $row["title"];
                $this->description = $row["description"];
                $this->departments = Subject::loadDepartments($this->subjectId);
                $this->assistants = Subject::loadAssistants($this->subjectId);
                $this->exercises = Subject::loadExercises($this->subjectId);
            }
            return true;
        } else return false;
    }

    public static function loadDepartments($subjectId)
    {

        $sql = "SELECT * FROM subject_department WHERE idSubject='{$subjectId}';";

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            $i = 0;
            $departments = array();
            while ($row = $result->fetch_assoc()) {
                $departments[$i]["department"] = new Department($row["idDepartment"]);
                $departments[$i]["department"]->load();
                $departments[$i]["year"] = $row["year"];
                $departments[$i]["semester"] = $row["semester"];
                $i++;
            }
            return $departments;
        } else return false;
    }

    public static function loadAssistants($subjectId)
    {

        $sql = "SELECT * FROM subject_assistant WHERE idSubject='{$subjectId}';";

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

    public static function loadExercises($subjectId)
    {

        $sql = "SELECT * FROM exercise WHERE idSubject='{$subjectId}';";

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            $i = 0;
            $exercises = array();
            while ($row = $result->fetch_assoc()) {
                $exercises[$i] = new Exercise($row["idExercise"]);
                $exercises[$i]->load();
                $i++;
            }
            return $exercises;
        } else return false;
    }

}