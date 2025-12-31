<?php

use App\Models\SkKepanitiaan;
use App\Models\JenisSK;

$sk = SkKepanitiaan::first();
if ($sk) {
    echo "SK Found: " . $sk->id . "\n";
    echo "JenisSK ID: " . $sk->jenissk_id . "\n";
    if ($sk->jenissk) {
        echo "Relation Found: " . $sk->jenissk->jenis_sk . "\n";
    } else {
        echo "Relation jenissk is NULL\n";
    }
} else {
    echo "No SK found\n";
}
