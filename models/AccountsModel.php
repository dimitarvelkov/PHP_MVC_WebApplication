<?php
class AccountsModel extends BaseModel {

    public function register($username,$password,$еmail){
        $statement = self::$db->prepare('SELECT COUNT(Id) FROM Users WHERE Username = ?');
        $statement->bind_param("s", $username);
        $statement->execute();
        $result =$statement->get_result()->fetch_assoc();

        if($result['COUNT(Id)']){
            return false;
        }

        $hash_password = password_hash($password,PASSWORD_BCRYPT);
        $registerStatement = self::$db->prepare('INSERT INTO Users (username, pass_hash,email) VALUES (?,?,?)');
        $registerStatement->bind_param("sss", $username,$hash_password,$еmail);
        $registerStatement->execute();
        $userId = $registerStatement->insert_id;

        return $userId;

    }

    public function login($username,$password) {
        $statement = self::$db->prepare('SELECT * FROM Users WHERE Username = ?');
        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();

        $isValidPass = password_verify($password, $result['pass_hash']);

        if($isValidPass){
            return $result;
        }

        return false;
    }
}