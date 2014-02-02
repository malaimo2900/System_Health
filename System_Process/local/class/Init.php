<?php

namespace local;


class Init {
	private $config;
	
	
	public function run() {
		$this->setupConfig();
	}
	
	
	private function setupConfig() {
		$conf = realpath(__DIR__.'/../../config/default.ini');
		if (is_readable($conf) && ($ini = parse_ini_file($conf, TRUE))) {
			$this->config = new \local\Config($ini);
		}
		unset($conf);
	}
}