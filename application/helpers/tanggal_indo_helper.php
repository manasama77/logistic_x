<?php
defined('BASEPATH') or exit('No direct script access allowed');

function tanggal_indo_no_dash($tanggal)
{
    $tgl_obj = new DateTime($tanggal);
    $hari    = $tgl_obj->format('d');
    $bulan   = bulan_indo($tgl_obj->format('m'));
    $tahun   = $tgl_obj->format('Y');

    return $hari . " " . $bulan . " " . $tahun;
}

function full_tanggal_indo_no_dash($tanggal)
{
    $tgl_obj   = new DateTime($tanggal);
    $nama_hari = hari_indo($tgl_obj->format('D'));
    $hari      = $tgl_obj->format('d');
    $bulan     = bulan_indo($tgl_obj->format('m'));
    $tahun     = $tgl_obj->format('Y');

    return $nama_hari . ", " . $hari . " " . $bulan . " " . $tahun;
}

function full_tanggal_jam_indo_no_dash($tanggal_jam)
{
    $tgl_obj   = new DateTime($tanggal_jam);
    $nama_hari = hari_indo($tgl_obj->format('D'));
    $hari      = $tgl_obj->format('d');
    $bulan     = bulan_indo($tgl_obj->format('m'));
    $tahun     = $tgl_obj->format('Y');
    $jam       = $tgl_obj->format('H');
    $menit     = $tgl_obj->format('i');

    return $nama_hari . ", " . $hari . " " . $bulan . " " . $tahun . " " . $jam . ":" . $menit;
}

function bulan_indo($bulan)
{
    if ($bulan == "01") {
        return "Januari";
    } elseif ($bulan == "02") {
        return "Februari";
    } elseif ($bulan == "03") {
        return "Maret";
    } elseif ($bulan == "04") {
        return "April";
    } elseif ($bulan == "05") {
        return "Mei";
    } elseif ($bulan == "06") {
        return "Juni";
    } elseif ($bulan == "07") {
        return "Juli";
    } elseif ($bulan == "08") {
        return "Agustus";
    } elseif ($bulan == "09") {
        return "September";
    } elseif ($bulan == "10") {
        return "Oktober";
    } elseif ($bulan == "11") {
        return "November";
    } elseif ($bulan == "12") {
        return "Desember";
    }
}

function hari_indo($hari)
{
    if ($hari == "Mon") {
        return "Senin";
    } elseif ($hari == "Tue") {
        return "Selasa";
    } elseif ($hari == "Wed") {
        return "Rabu";
    } elseif ($hari == "Thu") {
        return "Kamis";
    } elseif ($hari == "Fri") {
        return "Jumat";
    } elseif ($hari == "Sat") {
        return "Sabtu";
    } elseif ($hari == "Sun") {
        return "Minggu";
    }
}
