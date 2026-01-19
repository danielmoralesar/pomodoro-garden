<?php

use FFI\Exception;
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/User.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/core/CoreDB.php";
class UserDAO {

    /**
     * Inserta un nuevo usuario en la base de datos
     * Se verifica primero si el usuario tiene un id de -1 y que no tenga un email o username ya existentes, si no se cumple, devuelve null, si la inserción fue exitosa, se devuelve el id del usuario.
     * @param User $user
     * @return User|null
     */
    public static function create(User &$user): ?User{
        if ($user->getId() == -1 && !UserDAO::select($user->getEmail(), "email") && !UserDAO::select($user->getName(), "name")){
            $conn = CoreDB::getConn();
            $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $prSt = $conn->prepare($query);

            $name = $user->getName();
            $email = $user->getEmail();
            $hash = $user->getPassword();
            $prSt->bind_param("sss",$name, $email, $hash);
            try {
                $prSt->execute();
                $user->setId($prSt->insert_id);
                $conn->close();
                return $user;
            } catch (Exception $e) {
                $conn->close();
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Selecciona un usuario de la base de datos, necesitamos el dato a buscar y
     * el tipo de dato, el tipo solo puede ser id, name o email, otro tipo de dato dará error.
     * 
     * @param string $data
     * @param string $type
     * @return User|null
     */
    public static function select(string $data, string $type): ?User{
        if (!checkUserDataType($type)){
            return null;
        }
        $conn = CoreDB::getConn();
        $query =  "SELECT * FROM users WHERE $type = ?";
        $prSt = $conn->prepare($query);
        $prSt->bind_param("s", $data);
        $prSt->execute();
        $result = $prSt->get_result();
        if ($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $newU = new User(
                $row['name'],
                $row['email'],
                'DesconocemosLaContraseña',
                $row['id']
            );
            $conn->close();
            return $newU;
        }
        $conn->close();
        return null;
    }    
    
    /**
     * Actualiza los datos del usuario que se le pase,
     * Se puede cambiar todos los datos menos el ID.
     * El email y el name solo se pueden cambiar a otro mientras no exista uno similar en la base de datos
     * Primero se debe realizar el cambio en el objeto usuario y luego en la base de datos.
     * Si se hace al reves, se devolverá null
     * @param User $user
     * @return User|null
     */
    public static function update(User &$user):?User {
        if ($user !== UserDAO::select($user->getId(), "id") &&
            (!UserDAO::select($user->getEmail(), "email") ||
            !UserDAO::select($user->getName(), "name"))){
            $conn = CoreDB::getConn();
            $query = "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?";
            $prSt = $conn->prepare($query);
            $name = $user->getName();
            $email = $user->getEmail();
            $hash = $user->getPassword();
            $id = $user->getId();
            $prSt->bind_param("sssi", $name, $email, $hash, $id);
            try {
                $prSt->execute();
                $conn->close();
                return $user;
            } catch (Exception $e) {
                $conn->close();
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Verifica si las credenciales de inicio de sesión son correctas
     * @param string $email
     * @param mixed $pass
     * @return bool
     */
    public static function logIn(string $email, $pass): bool{
        $user = UserDAO::select($email, "email");
        if ($user){
            return password_verify($pass, $user->getPassword());
        } else {
            return false;
        }
    }

    public static function delete(User &$user){
        $conn = CoreDB::getConn();
        $query = "DELETE FROM users WHERE id = ?";
        $prSt = $conn->prepare($query);
        $id = $user->getId();
        $prSt->bind_param("i", $id);
        $prSt->execute();
        $result = $prSt->affected_rows > 0;
        $conn->close();
        return $result;
    }
}