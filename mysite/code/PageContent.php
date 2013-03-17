<?php

class PageContent extends DataObject {

	public static $default_sort = 'Title ASC';

    static $db = array(
		'Content' => 'HTMLText',
		'Page' => 'Varchar(1000)',
		'Title' => 'Varchar(100)'
    );
	
	static $summary_fields = array(
        'Title',
		'Page'
    );
	
	public function canCreate($member = NULL){ 
		return Permission::check('ADMIN');
	}
	
	public function canDelete($member = NULL){ 
		return Permission::check('ADMIN');
	}
	
	public function canEdit($member = NULL){ 
		return Permission::check('ADMIN');
	}
	
	public function canView($member = null) {
		return Permission::check('ADMIN');
    }

}