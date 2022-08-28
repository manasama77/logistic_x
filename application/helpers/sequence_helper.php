<?php
defined('BASEPATH') or exit('No direct script access allowed');

function empat_digit($seq)
{
    if ($seq < 10) {
        return "000" . $seq;
    } elseif ($seq < 100) {
        return "00" . $seq;
    } elseif ($seq < 1000) {
        return "0" . $seq;
    } else {
        return $seq;
    }
}
