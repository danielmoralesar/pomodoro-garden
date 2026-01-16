<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/User.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/core/CoreDB.php";
class UserDAO {


    public static function createUser(User $user){
        if ($user->getId() == -1){

        }
    }

    public static function selectUser(int $userId) {

    }

    public static function selectUserByEmailOrUserName(string $userEmail): ?User{
        $conn = CoreDB::getConn();
        $query = "SELECT * FROM user WHERE user.email = ?";
        $prSt = $conn->prepare($query);
        $prSt->bind_param("s", $userEmail);
        $prSt->execute();
        $result = $prSt->get_result();
        if ($result->num_rows == 1){
            $row = $result->fetch_assoc();
            return new User(
                $row['name'],
                $row['email'],
                'DesconocemosLaContraseña',
                $row['id']
            );
        } else {
            return null;
        }
    }
}