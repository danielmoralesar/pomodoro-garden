<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/User.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/core/CoreDB.php";
class UserDAO {

    /**
     * Insetta un nuevo usuario en la base de datos
     * Se verifica primero si el usuario tiene un id de -1 y que no tenga un email o username ya existentes, si no se cumple, devuelve null, si la inserción fue exitosa, se devuelve el id del usuario.
     * @param User $user
     * @return User|null
     */
    public static function createUser(User $user): ?User{
        if ($user->getId() == -1 && !UserDAO::selectUserByEmailOrUsername($user->getEmail(), true) && !UserDAO::selectUserByEmailOrUsername($user->getUserName(), false)){
            $conn = CoreDB::getConn();
            $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $prSt = $conn->prepare($query);

            $name = $user->getUserName();
            $email = $user->getEmail();
            $hash = $user->getPassword();
            $prSt->bind_param("sss",$name, $email, $hash);
            try {
                $prSt->execute();
                $user->setId($prSt->insert_id);
                return $user;
            } catch (Exception $e) {
                return null;
            }

        }
    }

    public static function selectUser(int $userId) {

    }

    public static function selectUserByEmailOrUsername(string $data, bool $type): ?User{
        $conn = CoreDB::getConn();
        $query =  "SELECT * FROM user WHERE " . ($type ? "email = ?" : "name = ?");
        $prSt = $conn->prepare($query);
        $prSt->bind_param("s", $data);
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
        }
        return null;
    }
}