<?php
class AjaxXML {

	// Create new XML document
	var $dom;
	var $elements = array('response');
	var $textNode = array();

	function AjaxXML($domEntry){
		// Clear Buffer
		if(ob_get_length()) ob_clean();
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Pragma: no-cache");
		// Set output type as XML
		header('Content-Type: text/xml; charset=utf-8');
		$this->dom = &$domEntry;
		$this->elements['response'] = $this->dom->createElement('response');
		$this->dom->appendChild($this->elements['response']);
	}

	function createChild($childTag, $parentTag = 'response'){
		$this->elements[$childTag] = $this->dom->createElement($childTag);
		$this->elements[$parentTag]->appendChild($this->elements[$childTag]);
	}

	function addText($text,$childTag){
		if(empty($text) || $text == '') $text = '&nbsp;';
		$this->textNode[$childTag] = $this->dom->createTextNode($text);
		$this->elements[$childTag]->appendChild($this->textNode[$childTag]);
	}

	function createMember($childTag){
		$this->elements[$childTag] = $this->dom->createElement($childTag);
	}

	function adoptChild($parentTag,$childTag){
		$this->elements[$parentTag] = appendChild($this->elements[$childTag]);
	}

	function getXML(){
		return $this->dom->saveXML();
	}

}
?>