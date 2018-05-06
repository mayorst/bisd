<?php

function isBefore($date1, $date2)
{
    // $dt1 = DateTime::createFromFormat('Y-m-d H:i', $date1);
    // $dt2 = DateTime::createFromFormat('Y-m-d H:i', $date2);
    $dt1 = new DateTime($date1);
    $dt2 = new DateTime($date2);

    $dt1->format('Y-m-d H:i');
    $dt2->format('Y-m-d H:i');

    // echo '====';
    // print_r($dt1);
    // print_r($dt2);
    // echo '====';

    if ($dt1 == $dt2) {
        return 0;
    } elseif ($dt1 < $dt2) {
        return 1;
    } elseif ($dt1 > $dt2) {
        return -1;
    } else {
        return false;
    }
}
