<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/Garden.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/functions.php";
class User{
    public function __construct(
        private string $userName,
        private string $password,
        private string $email,
        private array $gardens = []
    ){}

    /**
     * Create a new garden for the user, user must have unique title gardens,
     * it means that one user cannot have two gardens with the same name,
     * if a garden with the same title exist, return false, else create the garden and  
     * returns true true
     * @param string $gardenTitle new gardens title
     * @param string $environment environment for the new garden
     * @return bool
     */
    public function createGarden(string $gardenTitle, string $environment){
        if ($this->gardenExist($gardenTitle)){
            return false;
        } else {
            array_push(
            $this->gardens,
            new Garden($gardenTitle, $this, $environment));

            return true;
        }
    }
    /**
     * Find a garden by its name, if doesn't exist, return false
     * else return the garden
     * @param string $gardenTitle
     * @return Garden|bool
     */
    public function findGarden(string $gardenTitle):Garden | bool{
        return findSomethingByTitle( $gardenTitle, $this->gardens);
    }
    /**
     * Checks if garden exists by its name
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
     * Deletes a user's garden, if doesn't exist, returns false
     * if delete was sucesful, returns true
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

    public static function countAllPlants(User $user){
        
    }

    public function __tostring(){
        $gardens = "";
        foreach ($this->gardens as $garden) {
            $gardens .= $garden->getTitle() . ", ";
        }
        return "{$this->userName}, {$this->email}, " . $gardens;
    }

    public function getUserName()
    {
        return $this->userName;
    }
}
