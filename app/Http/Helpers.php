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
