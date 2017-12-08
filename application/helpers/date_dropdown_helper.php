<?php
defined('BASEPATH') OR exit('No direct script access allowed');
function buildDayDropdown($name = '', $value = '', $extra = '') {
    for ($day = 1; $day <= 31; $day++) {
        $days[] = $day;
    }
    return form_dropdown($name, $days, $value, $extra);
}

function buildYearDropdown($name = '', $value = '', $extra = '') {
    $years = range(1900, date("Y"));
    foreach ($years as $year) {
        $year_list[$year] = $year;
    }
    return form_dropdown($name, $year_list, $value, $extra);
}

function buildMonthDropdown($name = '', $value = '', $extra = '') {
    $month = array(
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December');
    return form_dropdown($name, $month, $value, $extra);
}
?>
