<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function formatTanggal($tanggal)
    {
        return Carbon::parse($tanggal)->locale('id')->translatedFormat('l, d F Y');
    }
}