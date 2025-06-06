<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FunctionController extends Controller
{   
    public static function calculateThreshold($target, $m)
    {
        return round($target < 0 ? $target * (1 + $m) : $target * (1 - $m), 4);
    }

    public static function calculateStretch($target, $n)
    {
        return round($target > 0 ? $target * (1 + $n) : $target * (1 - $n), 4);
    }

    public static function calculateScore($stretch, $target, $threshold, $actual)
    {
        if ($stretch > $target) {
            // KPI càng cao càng tốt
            if ($actual < $threshold) {
                return 0.0;
            } elseif ($actual < $target) {
                return round(($actual - $threshold) / ($target - $threshold), 4);
            } elseif ($actual < $stretch) {
                return round((($actual - $target) / ($stretch - $target)) + 1, 4);
            } else {
                return 2.0;
            }
        } else {
            // KPI càng thấp càng tốt
            if ($actual > $threshold) {
                return 0.0;
            } elseif ($actual > $target) {
                return round(($actual - $threshold) / ($target - $threshold), 4);
            } elseif ($actual > $stretch) {
                return round((($actual - $target) / ($stretch - $target)) + 1, 4);
            } else {
                return 2.0;
            }
        }
    }

    public static function toPercentage($decimal)
    {
        return round($decimal * 100, 2);
    }
}
