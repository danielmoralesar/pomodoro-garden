<?php
        require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/User.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/functions.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/plants/HarvestPlant.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/app/repositories/UserDAO.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/app/repositories/HarvestPlantDAO.php";

        $plant = new HarvestPlant("test", "test", "/resources/assets/silencePrincess.jpg",  time() + 60 * 60 * 24 * 7);
        $error = $plant;
        echo $plant;

        echo printForHtml("Creación:", "h1");
        HarvestPlantDAO::create($plant);
        echo $plant;

        echo printForHtml("Creación de una planta con el mismo title");
        var_dump(HarvestPlantDAO::create($error));

        echo "<hr>";

        echo printForHtml("Busqueda", "h1");
        echo printForHtml("por título");
        echo HarvestPlantDAO::select("test", "title");
        echo printForHtml("Por id:");
        echo HarvestPlantDAO::select($plant->getId(), "id");
        echo printForHtml("Con dato erróneo");
        var_dump(HarvestPlantDAO::select("true", "true"));

        echo "<hr>";
        echo printForHtml("Mostrar todas las plantas en la DB", "h1");

        $plant1 = (new HarvestPlant("test1", "test", "/resources/assets/silencePrincess.jpg",  time() + 60 * 60 * 24 * 7));
        $plant2 = new HarvestPlant("test2", "test", "/resources/assets/silencePrincess.jpg",  time() + 60 * 60 * 24 * 7);
        $plant3 = new HarvestPlant("test3", "test", "/resources/assets/silencePrincess.jpg",  time() + 60 * 60 * 24 * 7);

        HarvestPlantDAO::create($plant1);
        HarvestPlantDAO::create($plant2);
        HarvestPlantDAO::create($plant3);

        $plants = HarvestPlantDAO::selectAll();
        foreach ($plants as $plant) {
            echo $plant;
        }

        echo "<hr>";

        echo printForHtml("Update plants");
        $plant1->completeOrReopenTask(true);
        $plant1->calculateHealthPoints();
        $plant1->checkPlantState();
        $plant2->setTitle("Práctica PHP");
        
        echo HarvestPlantDAO::update($plant1);
        echo HarvestPlantDAO::update($plant2);

        echo printForHtml("Intentar hacer update de una planta que no ha hecho ningun cambio");
        
        $result = HarvestPlantDAO::update($plant3);
        var_dump($result);

        echo "<hr>";
        echo printForHtml("eliminar planta");
        var_dump(HarvestPlantDAO::delete($plant));