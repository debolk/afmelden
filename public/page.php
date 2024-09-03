<?php

class Page {

	private $header;
	private $footer;
	private $content;
	private $title;
	private $description;
	private $keywords;

	function __construct(){
		$this->header = file_get_contents('header.inc');
		$this->footer = file_get_contents('footer.inc');
	}
	
	function setTitle($title){
		$this->title = $title;	
	}
	
	function setContent($content){
		$this->content = $content;	
	}
	
	function setDescription($description){
		$this->description = $description;	
	}
	
	function setKeywords($keywords){
		$this->keywords = $keywords;	
	}
	
	function output(){
		$nheader = str_ireplace(array('##TITLE##', '##DESCRIPTION##', '##KEYWORDS##'), array($this->title, $this->description, $this->keywords), $this->header);
		echo $nheader . $this->content . $this->footer;
	}

}