<?php


include $_SERVER['DOCUMENT_ROOT'] . "/app/models/Plant.php";

class Garden {
    public function __construct(
        private string $title,
        private User $owner,
        private string $environment,
        private array $plants = []
    ){}

    public function newPlant($title, $description, $deadline){
        return new HarvestPlant($title, $description, false, $_SERVER['DOCUMENT_ROOT'] . "/resources/assets/greenTomato.png", $deadline);
    }



    public function getTitle()
    {
        return $this->title;
    }

    public function __tostring(){
        $plants = "";
        foreach ($this->plants as $plant) {
            $plants .= $plant->getTitle() . ", ";
        }
        return "{$this->title}, {$this->owner->getUserName()}, {$this->environment}, $plant";
    }
}