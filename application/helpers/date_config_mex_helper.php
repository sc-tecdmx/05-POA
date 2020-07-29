<?php

/**
 * Fecha exacta de la Cuidad de México
 * @return false|string
 */
function date_now($int = FALSE)
{
    date_default_timezone_set('America/Mexico_City');

    if ($int) {
        $date_now = new DateTime();
        return $date_now->getTimestamp();
    } else {
        return date('Y-m-d H:i:s');
    }
}