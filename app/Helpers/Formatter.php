<?php
if (!function_exists('convertToIDR')) {
    function convertToIDR($number) {
        return number_format($number, 0, ',', '.');
    }
}
?>
