<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/Garden.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/functions.php";
class User{
    public function __construct(
        private string $userName,
        private string $email,
        private string $password,
        private int $id = -1,
        private array $gardens = []
    ){
        $this->hashedPass = hashPass($password);
    }

    /**
     * Crea un nuevo jardín para el user, todos los jardines de cada usuarie deben tener titulos distintos.
     * @param string $gardenTitle nombre del nuevo jardín
     * @param string $environment Path del tipo de ambiente que tendrá el jardín, los jardines podrán tener diferentes fondos que se irán creando, algún ejemplo de fondo puede ser un invernadero de cristal o una terraza en la cima de un edificio
     * @return bool si se intenta crear un jardín con el mismo título de uno ya existente, se devolverá false, si se ha creado el jardín con éxito, se devolverá true
     */
    public function createGarden(string $gardenTitle, string $environment){
        if ($this->gardenExist($gardenTitle)){
            return false;
        } else {
            $this->gardens[] = new Garden($gardenTitle, $this, $environment);
            return true;
        }
    }

    /**
     * Verifica si el jardín existe por su nombre y lo devuelve
     * @param string $gardenTitle
     * @return Garden|bool
     */
    public function findGarden(string $gardenTitle):Garden | bool{
        return findSomethingByTitle( $gardenTitle, $this->gardens);
    }
    
    /**
     * Cambia el título de un jardín, verifica primero si el jardín existe y además si el nuevo nombre está disponible, en caso de que no se cumplan alguna de las dos condiciones, se devolverá falso
     * @param string $oldTitle 
     * @param string $newTitle 
     * @return bool
     */
    public function changeGardenTitle(string $oldTitle, string $newTitle){
        if($this->gardenExist($oldTitle) && !$this->gardenExist($newTitle)){
            foreach ($this->gardens as $garden) {
                if ($garden->getTitle() == $oldTitle){
                    $garden->setTitle($newTitle);
                    return true;
                }
            }
        }
        return false;
    }
    
    /**
     * Verifica si existe el jardín por su nombre
     * @param string $gardenTitle
     * @return bool
     */
    public function gardenExist(string $gardenTitle):bool{
        foreach ($this->gardens as $garden) {
            if ($gardenTitle == $garden->getTitle()){
                return true;
            }
        }
        return false;
    }
    
    
    /**
     * Elimina un jardín
     * 
     * Si la operación fue exitosa, devuelve true, sino, false
     * @param string $gardenTitle
     * @return bool
     */
    public function deleteGarden(string $gardenTitle){
        $garden = $this->findGarden($gardenTitle);
        if ($garden){
            echo printForHtml("Eliminando jardín...");
            array_splice($this->gardens, array_search($garden, $this->gardens), 1);
            return !$this->gardenExist($gardenTitle) ? true : false;
        } else {
            return false;
        }
    }

    /**
     * Método estático que muestra todas las tareas pendientes de un usuarie pasado por parámetro
     * @param User $user
     * @return string
     */
    public static function showAllUnattendedPlants(User $user){

        $unattendedPlants = "<ul>";
        foreach ($user->getGardens() as $garden){
            $unattendedPlants .= "<li>" . $garden->getTitle() . "<ul>";
            foreach ($garden->getPlants() as $plant) {
                if(!$plant->getTaskCompleted()) {
                    $unattendedPlants .= printForHtml("Titulo: " . $plant->getTitle() . " - Estado: " . $plant->getPlantState()->name, "li");
                }
            }
            $unattendedPlants .= "</ul>";
        }
        
        return $unattendedPlants;
    }

    public function __tostring(){
        $gardens = printForHtml("Jardines de {$this->userName}:"). (count($this->gardens) < 1 ? printForHtml("{$this->userName} no tiene jardines.") : printObjectArray($this->gardens));
        return 
            printForHtml(printForHtml("User: {$this->userName}; Email: {$this->email};") . $gardens, "div", "class", "object") ;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getGardens()
    {
        return $this->gardens;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    public function setGardens($gardens)
    {
        $this->gardens = $gardens;

        return $this;
    }
 
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
