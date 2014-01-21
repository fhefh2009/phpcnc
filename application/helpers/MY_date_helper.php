<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


function timespan($seconds = 1, $time = '')
{
    $CI =& get_instance();
    $CI->lang->load('date');

    if (!is_numeric($seconds)) {
        return;
    }

    if (!is_numeric($time)) {
        $time = time();
    }

    if ($time <= $seconds) {
        $seconds = 1;
    } else {
        $seconds = $time - $seconds;
    }

    $years = floor($seconds / 31536000);

    if ($years > 0) {
        return $years . ' ' . $CI->lang->line('date_year');
    }

    $months = floor($seconds / 2628000);

    if ($months > 0) {
        return $months . ' ' . $CI->lang->line('date_month');
    }

    $weeks = floor($seconds / 604800);


    if ($weeks > 0) {
        return $weeks . ' ' . $CI->lang->line('date_week');
    }


    $days = floor($seconds / 86400);

    if ($days > 0) {
        return $days . ' ' . $CI->lang->line('date_day');
    }


    $hours = floor($seconds / 3600);


    if ($hours > 0) {
        return $hours . ' ' . $CI->lang->line('date_hour');
    }


    $minutes = floor($seconds / 60);


    if ($minutes > 0) {
        return $minutes . ' ' . $CI->lang->line('date_minute');
    }


    return $seconds . ' ' . $CI->lang->line('date_second');

}