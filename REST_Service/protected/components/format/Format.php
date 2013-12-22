<?php


class Format extends CApplicationComponent {
	private $model;
	private $formatObj;
	
	
	public function init() {
		$this->output = strtoupper(Yii::app()->sc->outputAccept);
	}
	
	
	/**
	 * Will set the model to be processed
	 * @param CModel $model Is a model which is populated with request data
	 */
	public function setModel(CModel $model) {
		$this->model = $model;		
	}
	
	
	/**
	 * Will instantiate (JSON|XML)Format object
	 * and add the CModel instance to them
	 */
	private function setFormat() {
		$cl = $this->output.'Format';
		$this->formatObj = new $cl($this->model);
	}
	
	
	private function getFormattedOutput() {
		return $this->formatObj->getOutput();
	}
	
	
	public function __toString() {
		return $this->getFormattedOutput();
	}
}