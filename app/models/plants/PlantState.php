<?php

enum PlantState: int {
    case initial = 0;
    case seed = 1;
    case sprout = 2;
    case seedling = 3;
    case flowering = 4;
    case withering = -1;
    case withered = -2;
}