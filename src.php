<?php

function applyCaseBitmask($string, $bitmask) {
    for ($i = strlen($string) - 1; $i >= 0; $i--) {
        $string[$i] = ($bitmask & 1) ? strtoupper($string[$i]) : strtolower($string[$i]);
        $bitmask >>= 1;
    }
    return $string;
}

foreach (array('e', 'f', 'n', 'r', 't', 'v') as $e) {
    define($e, eval('return "\\' . $e . '";')); 
}

for ($i = 0; $i < 256; $i++) {
    $h = str_pad(dechex($i), 2, '0', STR_PAD_LEFT);
    $case_permutations = array_unique(array_map(function ($n) use ($h) {
        return applyCaseBitmask($h, $n);
    }, range(0, 3)));
    $value = eval('return "\\x' . $h . '";');
    foreach ($case_permutations as $permutation) {
        define('x' . $permutation, $value);
    }
}
