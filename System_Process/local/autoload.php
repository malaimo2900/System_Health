<?php

spl_autoload_register(function($class) {
	$classParts = explode('\\', $class);
	$classFile = __DIR__.'/class/'.$classParts[1].'.php';
	if (file_exists($classFile)) {
		require($classFile);
	}
	unset($classParts, $classFile);
});