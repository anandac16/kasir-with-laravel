<?php

$harga = (isset($argv[1]) ? $argv[1] : 7000);
$disc = (isset($argv[2]) ? $argv[2] : 5000);
$min_pembelian = (isset($argv[3]) ? $argv[3] : 3);
$qty = (isset($argv[4]) ? $argv[4] : 1);

function hitungDisc($qty, $disc, $min) {
   $tdisc = floor($qty / $min);
   return $disc * $tdisc;
}
function hitungHarga($harga, $qty, $disc) {
   $harga = ($harga * $qty) - $disc;
   return $harga;
}

$total_disc = hitungDisc($qty, $disc, $min_pembelian);
$total = hitungHarga($harga, $qty, $total_disc);
echo"Harga barang : ". number_format($harga, 2)."\r\n";
echo"Total Pembelian : ". number_format($qty, 2)."\r\n";
echo"Min. Discount Pembelian : ". number_format($min_pembelian, 2)."\r\n";
echo"Mendapat Discount : ". number_format($total_disc, 2)."\r\n";
echo"Total akhir : ". number_format($total, 2)."\r\n";