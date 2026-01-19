<?php

enum PlantState: string {
    case initial = "initial";
    case seed = "seed";
    case sprout = "sprout";
    case seedling = "seedling";
    case flowering = "flowering";
    case withering = "withering";
    case withered = "withered";

    public static function fromCaseName(string $caseName): ?self
    {
        $caseName = strtolower($caseName);
        foreach (self::cases() as $case) {
            if (strtolower($case->name) === $caseName) {
                return $case;
            }
        }
        return null;
    }
}