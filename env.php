<?php

function longest($input) {
    return array_reduce($input, function( $car, $item ) {
        return max($car,strlen($item));
    }, 0);
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
