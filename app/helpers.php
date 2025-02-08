<?php

if (!function_exists('_date')) {
    function _date($date, $format = 'Y-m-d')
    {
        try {
            if ($date == null) return $date;
            return date($format, strtotime($date));
        } catch (\Exception $ex) {
            Log::error("Gagal format tanggal: " . $ex->getMessage());
        }
        return $date;
    }
}

if (!function_exists('__date')) {
    /**
     * Format Indonesia / Setting Regional
     */
    function __date($date, $format = 'DD MMMM YYYY')
    {
        try {
            if ($date == null) return $date;
            return \Carbon\Carbon::parse($date)->locale('id')->isoFormat($format);
        } catch (\Exception $ex) {
            Log::error("Gagal format tanggal: " . $ex->getMessage());
        }
        return $date;
    }
}

if (!function_exists('_date_diff')) {
    function _date_diff($tanggal_awal, $tanggal_akhir)
    {
        try {
            $tanggal_awal  = new DateTime($tanggal_awal);
            $tanggal_akhir = new DateTime($tanggal_akhir);
            $interval      = $tanggal_akhir->diff($tanggal_awal);
            return abs($interval->format('%a'));
        } catch (\Exception $ex) {
            Log::error("Gagal hitung _date_diff: " . $ex->getMessage());
        }
        return 0;
    }
}