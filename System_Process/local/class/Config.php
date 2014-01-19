<?php

namespace local;

// do configuration of the application
class Config {
    private $validTypes = array(
        'database'
    );
    private $configData;
	
	
	/**
	 * Will initialize this configuration object
	 */
    public function __construct(array $config) {
		foreach ($this->validTypes as $type) {
			if (isset($config[$type])) {
				$this->{'set'.ucfirst($type)}($config[$type]);
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
        if (ArrayUtils::values_eq_keys($dbRequiredValues, $dsnConfig)) {
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
	
	/**
	 * Will return the requested configuration
	 * @param $type string - a configuration header
	 * @return mixed - array of values or FALSE upon no configuration section
	 */
	public function getConfig($type) {
		var_dump($this);die;
		if (isset($this->configData[$type]) && is_array($this->configData[$type])) {
			$result = $this->configData[$type];
		} else {
			$result = FALSE;
		}
		
		return $result;
	}
}