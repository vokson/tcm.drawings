<?php

namespace App\Tecnimont;

class Revision
{
    private static $revGrow = [
        'A1' => 0,
        'B1' => 1,
        '00' => 2,
        '01' => 3,
        '02' => 4,
        '03' => 5,
        '04' => 6,
        '05' => 7,
        '06' => 8,
        '07' => 9,
        '08' => 10,
        '09' => 11,
        '10' => 12,
        '11' => 13,
        '12' => 14,
        '13' => 15,
        '14' => 16,
        '15' => 17,
        '16' => 18,
        '17' => 19,
        '18' => 20,
        '19' => 21,
        '20' => 22,
        'SD' => 23,
        'VD' => 24
    ];

    public static function max($doc, $rev1, $rev2)
    {
        if ($rev1 == "AE") {
            var_dump($doc);
        }

        $i1 = self::$revGrow[$rev1];
        $i2 = self::$revGrow[$rev2];



        return ($i1 > $i2) ? $rev1 : $rev2;
    }
}
