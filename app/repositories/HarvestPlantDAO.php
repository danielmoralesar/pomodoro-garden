<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/app/core/CoreDB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/Plant.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/plants/HarvestPlant.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/plants/PlantState.php";

class HarvestPlantDAO{
    public static function create(HarvestPlant &$harvestPlant){
        if (!HarvestPlantDAO::select($harvestPlant->getTitle(), "title") && $harvestPlant->getId() == -1){
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
            $taskCompleted = $harvestPlant->getTaskCompleted() ? 0 : 1;
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
                return $e;
            }
        } else {
            return null;
        }
    }

    public static function select(string $data, string $type): ?HarvestPlant{
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
                PlantState::fromCaseName($row['plant_state']),
                PlantState::fromCaseName($row['previous_state']),
                ($row['task_completed'] == 0 ? true : false),
                $row['health_points'],
                $row['id']
            );
            $conn->close();
            return $plant;
        } else {
            return null;
        }
    }


    public static function selectAll(): ?array{
        $plants = null;
        $conn = CoreDB::getConn();
        $query = "SELECT * FROM plants";
        $prSt = $conn->prepare($query);
        $prSt->execute();
        $results = $prSt->get_result();
        while (($row = $results->fetch_assoc()) != null){
            $plants[] = new HarvestPlant(
                $row['title'],
                $row['description'],
                $row['plant_pic'],
                $row['deadline'],
                $row['planted_day'],
                PlantState::fromCaseName($row['plant_state']),
                PlantState::fromCaseName($row['previous_state']),
                ($row['task_completed'] == 0 ? true : false),
                $row['health_points'],
                $row['id']
            );
        }
        return $plants;
    }

    public static function update(HarvestPlant $harvestPlant): ?HarvestPlant{
        $plantDB = HarvestPlantDAO::select($harvestPlant->getTitle(), "title");
        if ($harvestPlant != HarvestPlantDAO::select($harvestPlant->getId(), "id") &&
        (!$plantDB || $plantDB->getId() == $harvestPlant->getId())){
            echo printForHtml("he pasado");
            $conn = CoreDB::getConn();
            $query = "UPDATE plants SET title = ?, description = ?, plant_pic = ?, deadline = ?, planted_day = ?, plant_state = ?, previous_state = ?, task_completed = ?, health_points = ? WHERE id = ?";
            $prSt = $conn->prepare($query);

            $title = $harvestPlant->getTitle();
            $description = $harvestPlant->getDescription();
            $plantPic = $harvestPlant->getPlantPic();
            $deadLine = $harvestPlant->getDeadLine();
            $plantedDay = $harvestPlant->getPlantedDay();
            $plantState = $harvestPlant->getPlantStateAsString();
            $previousState = $harvestPlant->getPreviousStateAsString();
            $taskCompleted = $harvestPlant->getTaskCompleted() ? 0 : 1;
            $healthPoints = $harvestPlant->getHealthPoints();
            $id = $harvestPlant->getId();

            $prSt->bind_param("sssiisssii",
                $title, $description, $plantPic, $deadLine, $plantedDay, $plantState, $previousState, $taskCompleted, $healthPoints, $id);

            try {
                $prSt->execute();
                $conn->close();
                return $harvestPlant;
            } catch (Exception $e) {
                $conn->close();
                return null;
            }
        } else {
            return null;
        }
    }

    public static function delete(HarvestPlant $harvestPlant){
        $conn = CoreDB::getConn();
        $query = "DELETE FROM plants WHERE id = ?";
        $prSt = $conn->prepare($query);
        $id = $harvestPlant->getId();
        $prSt->bind_param("i", $id);
        $prSt->execute();
        $result = $prSt->affected_rows > 0;
        $conn->close();
        return $result;
    }
}