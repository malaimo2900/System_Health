<?php

spl_autoload_register(function($class) {
	$classParts = explode('\\', $class);
	unset($classParts[0]);
	$classFile = __DIR__.'/class/'.implode('/', $classParts).'.php';
	var_dump($classFile);
	if (file_exists($classFile)) {
		require($classFile);
	}
	unset($classParts, $classFile);
});