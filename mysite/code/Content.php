<?php

class Content_Controller extends Share_Controller {

	public static $allowed_actions = array (
		'get'
	);
	
	public function init() {
		parent::init();
	}
	
	public function index() {
		//
	}
	
	public function get() {
		$params = $this->getURLParams();
		$page = (string)$params['ID'];
		
		$text = PageContent::get()->filter(array(
			'Page' => $page
		))->First();
		
		if ($text) {
			return $this->renderWith('PageContent', array(
				'Text' => $text->Content,
				'Title' => $text->Title
			)); 
		} else {
			// redirect
		}
	}
	
}