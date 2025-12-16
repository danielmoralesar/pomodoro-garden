<?php

enum PlantState: String {
    case seed = "seed";
    case sprout = "sprout";
    case seedling = "seedling";
    case flowering = "flowering";
    case withering = "withering";
    case withered = "withered";
}