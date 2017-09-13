<?php

function adminer_object() {

  // Required
  include_once "./plugins/plugin.php";

  // Autoloader
  foreach(glob("./plugins/*.php") as $file) {
    include_once $file;
  }

  // Select plugins to enable
  $plugins = array(
    new AdminerDumpJson(),
  );

  // Enable the chosen plugins
  return new AdminerPlugin($plugins);
}

// and adminer itself
$files = glob('adminer-*.php');
sort($files);
include array_pop($files);
