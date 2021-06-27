<?php
namespace App\Helpers;

class DateHelper{

    public static function hari($day)
    {
        $har = [
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu',
        ];
        return $har[$day];
    }
}
?>