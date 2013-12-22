<?php


Yii::import('application.components.format.BaseFormat');


/**
 * Will utilize DomDocument to transform a Yii::Cmodel into a DomDocument
 * XML object.
 */
class XMLFormat extends BaseFormat {
	
	protected function formatter() {
		$d = new DomDocument();
		
		foreach ($this->getData() as $data) {
			$node = new DOMNode();
			$node->set_name($data[0]);
			$node->set_content($data[1]);
			$d->appendChild($node);
		}
		
		unset($node);
		
		$this->output = $d->saveXML();
	}
}
