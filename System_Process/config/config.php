<?php

// do configuration of the application
class Config {
    private static $validTypes = array(
        'database'
    );
    private $configData;
    private static $instasnce = null;
	
	/**
	 * 
	 */
	public function obj() {
		if (!(self::$instance instanceOf Config)) {
			self::$instance = new Config();
		}
		
		return self::$instance;
	}
	
	
	/**
	 * Will initialize this configuration object
	 */
    public function init(array $config) {
		foreach ($this->validTypes as $type) {
			if (isset($config[$type])) {
				$this->{'set'.ucfirst($config)}($config[$type]);
			}
		}
    }
	
	
    /**
	 * sets the database dsn
	 */
    private function setDatabase($dsnConfig) {
        // define global DB properties
        $dbRequiredValues = array('user_name', 'user_pass', 'dbname', 'engine', 'host');
		
        // check db values in config for required values set
        if (arrayUtils::values_eq_keys($dbRequiredValues, $dsnConfig)) {
        	throw new Exception('Invalid database parameters set: '.__FILE__.' at lineno: '.__LINE__);
        } else {
            $this->dbInfo = $dsnConfig;
			$this->configData['database']['DB_DSN'] = $dsnConfig['engine'].':dbname='.$dsnConfig['dbname'].';host='.$dsnConfig['host'];
			
            unset($dsnConfig['engine'], $dsnConfig['dbname'], $dsnConfig['host']);
			
            foreach ($dsnConfig as $varName => $value) {
                $this->configData['database']['DB_'.strtoupper($varName)] = $value;
            }
        }
    }
}