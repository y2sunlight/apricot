<?php
namespace App\Helpers;

/**
 * View Helper
 */
class ViewHelper
{
    /**
     * Returns a formatted date string.
     *
     * This method is an example of a view helper.
     *
     * @param string $datetime
     * @param string $format
     * @return string
     */
    static function formatDatetime(string $datetime, string $format='Y-m-d'):string
    {
        return date($format, strtotime($datetime));
    }
}