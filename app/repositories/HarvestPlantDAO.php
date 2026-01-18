<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/app/core/CoreDB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/Plant.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/plants/HarvestPlant.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/plants/PlantState.php";

class HarvestPlantDAO{
    public static function create(HarvestPlant &$harvestPlant): ?HarvestPlant{
        if (!HarvestPlantDAO::select($harvestPlant->getTitle(), "title")){
            $conn = CoreDB::getConn();
            $query = "INSERT INTO plants (title, description, plant_pic, deadline, planted_day, plant_state, previous_state, task_completed, health_points)VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $prSt = $conn->prepare($query);

            $title = $harvestPlant->getTitle();
            $description = $harvestPlant->getDescription();
            $plantPic = $harvestPlant->getPlantPic();
            $deadLine = $harvestPlant->getDeadLine();
            $plantedDay = $harvestPlant->getPlantedDay();
            $plantState = $harvestPlant->getPlantStateAsString();
            $previousState = $harvestPlant->getPreviousStateAsString();
            $taskCompleted = $harvestPlant->getTaskCompleted();
            $healthPoints = $harvestPlant->getHealthPoints();

            $prSt->bind_param("sssiisssi",
                $title, $description, $plantPic, $deadLine, $plantedDay, $plantState, $previousState, $taskCompleted, $healthPoints);

            try {
                $prSt->execute();
                $harvestPlant->setId($prSt->insert_id);
                $conn->close();
                return $harvestPlant;
            } catch (Exception $e){
                $conn->close();
                return null;
            }
        } else {
            return null;
        }
    }

    public static function select(string $data, string $type){
        if (!checkPlantDataType($type)){
            return null;
        }
        $conn = CoreDB::getConn();
        $query = "SELECT * FROM plants WHERE $type = ?";
        $prSt = $conn->prepare($query);
        $prSt->bind_param("s", $data);
        $prSt->execute();
        $result = $prSt->get_result();
        if ($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $plant = new HarvestPlant(
                $row['title'],
                $row['description'],
                $row['plant_pic'],
                $row['deadline'],
                $row['planted_day'],
                $row['plant_state'],
                $row['previous_state'],
                $row['task_completed'],
                $row['health_points'],
                $row['id']
            );
            $conn->close();
            return $plant;
        } else {
            return null;
        }
    }


    public static function selectAll(HarvestPlant $harvestPlant){

    }

    public static function update(HarvestPlant $harvestPlant){

    }

    public static function delete(HarvestPlant $harvestPlant){

    }
}