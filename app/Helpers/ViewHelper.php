<?php
namespace App\Helpers;

class ViewHelper
{
    /**
     * 日時のフォーマット
     * @param string $datetime
     * @param string $format
     * @return string
     */
    static function formatDatetime(string $datetime, string $format='Y-m-d'):string
    {
        return date($format, strtotime($datetime));
    }
}