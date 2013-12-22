<?php


Yii::import('application.components.format.BaseFormat');


/**
 * Will utilize DomDocument to transform a Yii::Cmodel into a JSON string
 */
class JSONFormat extends BaseFormat {
	
	protected function formatter() {
		$array = [];
		
		foreach ($this->getData() as $data) {
			$array[$data[0]] = $data[1];
		}
		
		$this->output = json_encode($array);
	}
}
