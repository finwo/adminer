<?php

function prnt($element) {
    $type = gettype($element);
    printf('<ul style="list-style:none;">');
    switch(gettype($element)) {
        case 'object':
            $type = get_class($element);
            $element = (array)$element;
        case 'array':
            printf("<li><b>%s</b>");
            array_walk($element, 'prnt');
            printf("</li>");
            break;
        default:
            printf("<li><b>%s</b><p>%s</p></li>", $type, $element);
            break;
    }
    printf('</ul>');
}

prnt($_ENV);
