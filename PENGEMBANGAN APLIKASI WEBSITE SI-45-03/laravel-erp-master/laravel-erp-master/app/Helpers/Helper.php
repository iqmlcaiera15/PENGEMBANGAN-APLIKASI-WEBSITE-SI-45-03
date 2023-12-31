<?php

function format_rupiah($angka)
{
    if (is_numeric($angka)) {
        $rupiah = "Rp " . number_format($angka, 0, ',', '.');
        return $rupiah;
    } else {
        return "Input bukan angka";
    }
}
