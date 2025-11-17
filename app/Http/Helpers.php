<?php

if (!function_exists('merge')) {
    function merge($arrays)
    {
        $result = [];

        foreach ($arrays as $array) {
            if ($array !== null) {
                if (gettype($array) !== 'string') {
                    foreach ($array as $key => $value) {
                        if (is_integer($key)) {
                            $result[] = $value;
                        } elseif (isset($result[$key]) && is_array($result[$key]) && is_array($value)) {
                            $result[$key] = merge([$result[$key], $value]);
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $result[count($result)] = $array;
                }
            }
        }

        return join(" ", $result);
    }
}

if (!function_exists('uncamelize')) {
    function uncamelize($camel, $splitter = "_")
    {
        $camel = preg_replace('/(?!^)[[:upper:]][[:lower:]]/', '$0', preg_replace('/(?!^)[[:upper:]]+/', $splitter . '$0', $camel));
        return strtolower($camel);
    }
}
// make function helper page
if(!function_exists('linkPagination')){
    function linkPagination($path, $perPage = 10, $search = null, $page = null)
    {
        $url = $path . '?';
        if ($search) {
            $url .= 'search=' . $search . '&';
        }
        if ($perPage) {
            $url .= 'per_page=' . $perPage . '&';
        }
        if ($page) {
            $url .= 'page=' . $page . '&';
        }
        return $url;
    }
}
if(!function_exists('toThousand')){
    function toThousand($amount, $prefix = 'Rp ')
    {
        return $prefix .number_format($amount, 0, ',', ',');
    }
}
if(!function_exists('curencyToInteger')){
    function curencyToInteger($amount)
    {
        // replace Rp. and . and ,
        return (int) str_replace(['Rp', '.', ','], '', $amount);
    }
}
if(!function_exists("terbilang")){
    function terbilang($angka)
    {
        $angka = abs($angka);
        $huruf = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
        $hasil = "";
        
        if ($angka < 12) {
            $hasil = " " . $huruf[$angka];
        } elseif ($angka < 20) {
            $hasil = terbilang($angka - 10) . " belas";
        } elseif ($angka < 100) {
            $hasil = terbilang($angka / 10) . " puluh" . terbilang($angka % 10);
        } elseif ($angka < 200) {
            $hasil = " seratus" . terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $hasil = terbilang($angka / 100) . " ratus" . terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $hasil = " seribu" . terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $hasil = terbilang($angka / 1000) . " ribu" . terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $hasil = terbilang($angka / 1000000) . " juta" . terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $hasil = terbilang($angka / 1000000000) . " milyar" . terbilang(fmod($angka, 1000000000));
        } elseif ($angka < 1000000000000000) {
            $hasil = terbilang($angka / 1000000000000) . " trilyun" . terbilang(fmod($angka, 1000000000000));
        }
        
        return trim($hasil);
    }
}

