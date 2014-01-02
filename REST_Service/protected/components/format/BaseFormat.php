<?php


abstract class BaseFormat extends CApplicationComponent {
	protected $output = null; /// This will contain the contents of the class output
	protected $model = null; /// The model of the request data
	
	
	abstract protected function formater();
	
	
	public function __construcrt(CModel $model) {
		$this->mdel = $model;
	}
	
	
	public function getData() {
		foreach ($this->model as $attr => $value) {
			yield array($attr, $value);
		}
	}
	
	 
	/**
	 * Returns the contents of variable $output
	 * return String 
	 */
	public function getOutput() {
		return $this->output;
	}
	
	
	public function __toString() {
		return $this->getOutput();
	}
}
