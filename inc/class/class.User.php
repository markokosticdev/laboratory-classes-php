<?php

spl_autoload_register(function ($class) {
    require_once "class." . $class . ".php";
});

abstract class User implements JsonSerializable
{

    protected static $instanceNumber = 0;
    protected $userId;
    protected $username;
    protected $password;
    protected $type;
    protected $status;
    protected $fname;
    protected $lname;
    protected $email;
    protected $picture;
    protected $description;

    protected function __construct($userId = null)
    {

        if (!is_null($userId)) {
            if (is_numeric($userId)) $this->userId = $userId;
            else $this->username = $userId;
        }
    }

    public static function getId($username, $password)
    {

        $sql = "SELECT idUser FROM user WHERE username='{$username}' AND password='{$password}';";
        $result = Database::getInstance()->query($sql);
        if ($result != false) return $result->fetch_row()[0];
        else return false;
    }

    public static function loadAll($type = null)
    {

        if (is_null($type)) $sql = "SELECT * FROM user;";
        else $sql = "SELECT * FROM user WHERE idType='{$type}';";

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            $i = 0;
            $users = array();
            while ($row = $result->fetch_assoc()) {
                $users[$i]["userId"] = $row["idUser"];
                $users[$i]["username"] = $row["username"];
                $users[$i]["type"] = $row["idType"];
                $users[$i]["status"] = $row["status"];
                $users[$i]["fname"] = $row["fname"];
                $users[$i]["lname"] = $row["lname"];
                $users[$i]["email"] = $row["email"];
                $users[$i]["picture"] = $row["picture"];
                $users[$i]["description"] = $row["description"];
                $i++;
            }
            return $users;
        } else return false;
    }

    public static function loadSelected($userIds)
    {

        if (is_array($userIds)) {
            $userIdsIn = implode(",", $userIds);
            $sql = "SELECT * FROM user WHERE idUser IN ({$userIdsIn});";
        } elseif (!is_null($userIds)) {
            $sql = "SELECT * FROM user WHERE idUser='{$userIds}';";
        } else return false;

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            $i = 0;
            $users = array();
            while ($row = $result->fetch_assoc()) {
                $users[$i]["userId"] = $row["idUser"];
                $users[$i]["username"] = $row["username"];
                $users[$i]["type"] = $row["idType"];
                $users[$i]["status"] = $row["status"];
                $users[$i]["fname"] = $row["fname"];
                $users[$i]["lname"] = $row["lname"];
                $users[$i]["email"] = $row["email"];
                $users[$i]["picture"] = $row["picture"];
                $users[$i]["description"] = $row["description"];
                $i++;
            }
            return $users;
        } else return false;
    }

    public static function toObject($array)
    {

        $object = User::getUser($array["type"]);
        foreach ($array as $key => $value) {
            $object->$key = $value;
        }
    }

    public static function getUser($type, $userId = null)
    {

        switch ($type) {
            case 1:
                return new Administrator($userId);
                break;
            case 2:
                return new Assistant($userId);
                break;
            case 3:
                return new Helper($userId);
                break;
            default:
                return null;
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

    public static function add($username, $password, $type, $status, $fname, $lname, $email, $picture = null, $description = null)
    {

        if (!self::isExist($username, $password)) {
            $picture = (is_null($picture)) ? NULL : $picture;
            $description = (is_null($description)) ? NULL : $description;

            $sql = "INSERT INTO user (idUser,username,password,idType,status,fname,lname,email,picture,description)
VALUES (NULL, '{$username}', '{$password}','{$type}', '{$status}', '{$fname}', '{$lname}', '{$email}', '{$picture}', '{$description}');";
            $result = Database::getInstance()->update($sql);
            return true;
        } else return false;
    }

    public static function isExist($username, $password = null)
    {

        if (!is_null($password))
            $sql = "SELECT * FROM user WHERE username='{$username}' AND password='{$password}';";
        else {
            if (is_numeric($username)) {
                $sql = "SELECT * FROM user WHERE idUser='{$username}';";
            } else {
                $sql = "SELECT * FROM user WHERE username='{$username}';";
            }
        }

        $result = Database::getInstance()->query($sql);
        if ($result->fetch_array() != false) return true;
        else return false;
    }

    public static function update($userId, $username, $password, $type, $status, $fname, $lname, $email, $picture = null, $description = null)
    {

        if (self::isExist($userId)) {
            $picture = (is_null($picture)) ? NULL : $picture;
            $description = (is_null($description)) ? NULL : $description;

            $sql = "UPDATE user
                    SET username='{$username}',
                    password='{$password}',
                    idType='{$type}',
                    status='{$status}',
                    fname='{$fname}',
                    lname='{$lname}',
                    email='{$email}'";
            $sql .= ($picture == NULL) ? "" : ", picture='{$picture}'";
            $sql .= ($description == NULL) ? "" : ", description='{$description}'";
            $sql .= "WHERE idUser='{$userId}';";

            $result = Database::getInstance()->update($sql);
            return true;
        } else return false;
    }

    public static function delete($userId)
    {

        $sql = "DELETE FROM user WHERE idUser='{$userId}'";
        $result = Database::getInstance()->update($sql);

        if ($result) {
            return true;
        } else return false;
    }

    public static function deletePicture($userId)
    {

        $user = self::getUser(self::getType($userId), $userId);
        $user->load();

        if (unlink($user->picture) && rmdir(pathinfo($user->picture, PATHINFO_DIRNAME))) return true;
        else return false;
    }

    public static function getType($userId)
    {

        $sql = "SELECT idType FROM user WHERE idUser='{$userId}';";
        $result = Database::getInstance()->query($sql);
        if ($result != false) return $result->fetch_row()[0];
        else return false;
    }

    public function load($password = null)
    {

        if (is_null($password)) {
            if (isset($this->userId)) $sql = "SELECT * FROM user WHERE idUser='{$this->userId}';";
            else return false;
        } else if (isset($this->username)) {
            $sql = "SELECT * FROM user WHERE username='{$this->username}' AND password='{$password}';";
        } else return false;

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            while ($row = $result->fetch_assoc()) {
                $this->username = $row["username"];
                $this->password = $row["password"];
                $this->type = $row["idType"];
                $this->status = $row["status"];
                $this->fname = $row["fname"];
                $this->lname = $row["lname"];
                $this->email = $row["email"];
                $this->picture = $row["picture"];
                $this->description = $row["description"];
            }
            return true;
        } else return false;
    }

    abstract public function __get($name);

    abstract public function __set($name, $value);

    abstract public function __clone();

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function loadPassword()
    {

        if (isset($this->userId)) $sql = "SELECT * FROM user WHERE idUser='{$this->userId}';";
        else return false;

        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            while ($row = $result->fetch_assoc()) {
                $this->password = $row["password"];
            }
            return true;
        } else return false;
    }

    public function loadPasswordTo()
    {

        if (isset($this->userId)) $sql = "SELECT * FROM user WHERE idUser='{$this->userId}';";
        else return false;

        $password = false;
        $result = Database::getInstance()->query($sql);
        if ($result != false) {
            while ($row = $result->fetch_assoc()) {
                $password = $row["password"];
            }
            return $password;
        } else return false;
    }


}