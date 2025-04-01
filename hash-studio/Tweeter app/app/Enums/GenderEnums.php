<?php

namespace App\Enums;

enum GenderEnums: string
{
    case Male = 'male';
    case Female = 'female';
    
    /**
     * Get all the enum Gender as an associative array.
     *
     * @return array
     */
    public static function Genders(): array
    {
        return [
            self::Male->name => 'Male',
            self::Female->name => 'Female',
        ];
    }
}
