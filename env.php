<?php

function longest($input) {
    $l = 0;
    foreach ($input as $item) {
        $l = max($l, strlen($item));
    }
    return $l;
}

print("<pre>");
$keys = array_keys($_ENV);
sort($keys);
$len=longest($keys);
printf("%s\n\n", count($keys));
foreach ($keys as $key) {
    printf("%s _%s => (%s) ", $key, str_repeat('_', $len-strlen($key)), gettype($_ENV[$key]));
    switch (gettype($_ENV[$key])) {
        case 'object':
            $_ENV[$key] = (array)$_ENV[$key];
        case 'array':
            print(http_build_query($_ENV[$key]));
            print("\n");
            break;
        default:
            print($_ENV[$key]);
            print("\n");
            break;
    }
}
print("</pre>");
