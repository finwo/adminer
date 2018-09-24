<?php

function adminer_object() {

    // Required
    require_once "./plugins/plugin.php";

    // Helper functions
    // https://stackoverflow.com/a/2051010
    function file_get_php_classes($filepath) {
        $php_code = file_get_contents($filepath);
        $classes = get_php_classes($php_code);
        return $classes;
    }
    function get_php_classes($php_code) {
        $classes = array();
        $tokens = token_get_all($php_code);
        $count = count($tokens);
        for ($i = 2; $i < $count; $i++) {
            if ($tokens[$i - 2][0] == T_CLASS
                && $tokens[$i - 1][0] == T_WHITESPACE
                && $tokens[$i][0] == T_STRING) {

                $class_name = $tokens[$i][1];
                $classes[] = $class_name;
            }
        }
        return $classes;
    }

    // Fetch all plugins
    $plugins = array();
    foreach (glob("./plugins/*.php") as $file) {
        if($file=='./plugins/plugin.php') continue;
        $classes    = file_get_php_classes($file);
        $configFile = preg_replace('/.[^.]*$/','',$file).'.json';
        $config     = file_exists($configFile) ? json_decode(file_get_contents($configFile), true) : null;
        require_once($file);
        foreach( $classes as $c ) {
          array_push($plugins,[$c,$config]);
        }
    }

  // Enable the found plugins
  return new AdminerPlugin(array_map(function($plugin) {
      $rc  = new ReflectionClass(array_shift($plugin));
      $arg = array_shift($plugin);
      if (is_null($arg)) {
          return $rc->newInstance();
      }
      return $rc->newInstance($arg);
  }, $plugins));
}


// Load the most recent adminer version
call_user_func(function () {
    $files = glob('adminer-*.php');
    sort($files);
    require(array_pop($files));
});
