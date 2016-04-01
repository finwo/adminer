<?php

$files = glob('adminer-*.php');
sort($files);

include array_pop($files);

