<?php

class Genre extends DataObject {

	public static $default_sort = 'Title ASC';

    static $db = array(
		'Title' => 'Varchar(100)'
    );
	
	static $summary_fields = array(
        'Title'
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
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }
	
}