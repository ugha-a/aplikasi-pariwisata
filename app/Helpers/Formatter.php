<?php
if (!function_exists('convertToIDR')) {
    function convertToIDR($number) {
        return 'Rp ' . number_format($number, 0, ',', '.');
    }
}
?>
