<?php

if (!function_exists('convertToIDR')) {
    /**
     * Format angka ke Rupiah.
     * @param int|float|string $number
     * @param bool $withPrefix  true => "Rp 1.000", false => "1.000"
     */
    function convertToIDR($number, bool $withPrefix = true): string
    {
        $formatted = number_format((float)$number, 0, ',', '.');
        return $withPrefix ? 'Rp ' . $formatted : $formatted;
    }
}
