<?php

// include plugins
foreach(glob('plugin/*.php') as $file) {
    include($file);
}

// and adminer itself
$files = glob('adminer-*.php');
sort($files);
include array_pop($files);
