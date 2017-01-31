<?php

spl_autoload_register(function ($class) {
    require_once "class." . $class . ".php";
});

class Term implements JsonSerializable
{

    private $termId;
    private $assistants = array();
    private $laboratory;
    private $datetime;

    public function __construct($termId = null)
    {

        if (!is_null($termId)) {
            $this->termId = $termId;
        }
    }

    public static function isExist($termId)
    {

        $sql = "SELECT * FROM term WHERE idTerm='{$termId}';";

        $result = Database::getInstance()->query($sql);
        if ($result->fetch_array() != false) return true;
        else return false;
    }

    public static function loadAll()
    {

        $sql = "SELECT * FROM term;";

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            $i = 0;
            $terms = array();
            while ($row = $result->fetch_assoc()) {
                $terms[$i]["termId"] = $row["idTerm"];
                $terms[$i]["assistants"] = Term::loadAssistants($row["idTerm"]);
                $terms[$i]["laboratory"] = new Laboratory($row["idLaboratory"]);
                $terms[$i]["laboratory"]->load();
                $terms[$i]["datetime"] = $row["datetime"];
                $i++;
            }
            return $terms;
        } else return false;
    }

    public static function loadSelected($termIds, $by = "term")
    {

        if (is_array($termIds)) {
            $termIdsIn = implode(",", $termIds);
            $sql = "SELECT * FROM term WHERE idTerm IN ({$termIdsIn});";
        } elseif (is_numeric($termIds) && $by == "term") {
            $sql = "SELECT * FROM term WHERE idTerm='{$termIds}';";
        } else if ($by == "exercise") {
            $sql = "SELECT * FROM term WHERE idExercise='{$termIds}';";
        } else return false;

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            $i = 0;
            $terms = array();
            while ($row = $result->fetch_assoc()) {
                $terms[$i]["termId"] = $row["idTerm"];
                $terms[$i]["assistants"] = Term::loadAssistants($row["idTerm"]);
                $terms[$i]["laboratory"] = new Laboratory($row["idLaboratory"]);
                $terms[$i]["laboratory"]->load();
                $terms[$i]["datetime"] = $row["datetime"];
                $i++;
            }
            return $terms;
        } else return false;
    }

    public static function toObject($array)
    {

        $object = new Term();
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

    public static function add($exercise, $assistants, $laboratory, $datetime)
    {
        $exerciseId = (is_numeric($exercise)) ? $exercise : $exercise->exerciseId;
        $laboratoryId = (is_numeric($laboratory)) ? $laboratory : $laboratory->laboratoryId;

        $sql = "INSERT INTO term (idTerm,idExercise,idLaboratory,datetime)
VALUES (NULL, '{$exerciseId}', '{$laboratoryId}', '{$datetime}');";
        $result = Database::getInstance()->update($sql);
        if (!$result) return false;

        $termId = Database::getInstance()->getInsertId();

        foreach ($assistants as $val) {
            $sql = "INSERT INTO term_assistant (idUser,idTerm)
                            VALUES ('{$val->userId}', '{$termId}');";
            $result = Database::getInstance()->update($sql);
            if (!$result) return false;
        }

        return true;
    }

    public static function update($termId, $exercise, $assistants, $laboratory, $datetime)
    {

        $exerciseId = (is_numeric($exercise)) ? $exercise : $exercise->exerciseId;
        $laboratoryId = (is_numeric($laboratory)) ? $laboratory : $laboratory->laboratoryId;

        $sql = "UPDATE term
                    SET idExercise='{$exerciseId}', idLaboratory='{$laboratoryId}', datetime='{$datetime}'";
        $sql .= "WHERE idTerm='{$termId}';";
        $result = Database::getInstance()->update($sql);
        if (!$result) return false;

        $sql = "DELETE FROM term_assistant WHERE idTerm='{$termId}'";
        $result = Database::getInstance()->update($sql);
        if (!$result) return false;

        foreach ($assistants as $val) {
            $sql = "INSERT INTO term_assistant (idUser,idTerm)
                            VALUES ('{$val->userId}', '{$termId}');";
            $result = Database::getInstance()->update($sql);
            if (!$result) return false;
        }

        return true;
    }

    public static function delete($termId)
    {

        $sql = "DELETE FROM term WHERE idTerm='{$termId}'";
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

        if (property_exists("Term", $this->$name))
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

        if (isset($this->termId)) {
            $sql = "SELECT * FROM term WHERE idTerm='{$this->termId}';";
        } else return false;

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            while ($row = $result->fetch_assoc()) {
                $this->assistants = Term::loadAssistants($this->termId);
                $this->laboratory = new Laboratory($row["idLaboratory"]);
                $this->laboratory->load();
                $this->datetime = $row["datetime"];
            }
            return true;
        } else return false;
    }

    public static function loadAssistants($termId)
    {

        $sql = "SELECT * FROM term_assistant WHERE idTerm='{$termId}';";

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

}