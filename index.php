<?php

// include plugins
$files = glob('plugins/*.php');
sort($files);
foreach($files as $file) {
    include($file);
}

// and adminer itself
$files = glob('adminer-*.php');
sort($files);
include array_pop($files);
