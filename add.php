#!/usr/bin/php
<?php
  
  function _exec($cmd) {
      echo "CMD $cmd\n";
      $ret = 0;
	  passthru($cmd, $ret);
	  return $ret;
  }
  
  function check($ret) {
     if($ret !== 0) {
       echo "RETURN: $ret\n";
       echo "CANCELLED!\n\n";
       die();
     }
  }
  
  function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}
  
global $curDir;
$curDir = getcwd();
$dep = $argv[1];

if(file_exists($dep)) {
  addFromFile($dep);
} else {
	add($dep);
}

function add($dep) {
	global $curDir;
	
	var_dump($dep);
	
	$packageJsonFile = $curDir . '/node_modules/' . $dep . '/package.json';
	
	$content = @file_get_contents($packageJsonFile);
	if($content && strlen($content) > 10) {
	   echo 'Skipping ' . $dep . "\n";
	   return;
	}

	echo "Adding '$dep'\n";

	$ret = _exec('yarn add ' . $dep);
	check($ret);

	$content = @file_get_contents($packageJsonFile);
	if(!$content) {
	    echo "ERR: PACKAGE.JSON $packageJsonFile not found\n";
		return;
	}
	
	$content = json_decode($content);

	if(startsWith($dep, 'react-native-')) {
	
		$ret = _exec('react-native link ' . $dep);
		check($ret);

		$ret = _exec('cd android && ./gradlew assembleDebug');
		check($ret);
		_exec('cd ' . $curDir);
	}
}

function addFromFile($filename) {
	if ($file = fopen($filename, "r")) {
    	while(!feof($file)) {
        	$line = trim(fgets($file));
        	if($line)
				add($line);
	    }
    	fclose($file);
	}
}
