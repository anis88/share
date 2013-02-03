<?php

class Profile_Controller extends Share_controller {

	public static $allowed_actions = array (
		'edit'
	);
	
	public function init() {
		parent::init();
	}
		
	public function edit() {	
		if ( ! $member = MyMember::get()->filter('ID', Member::currentUserID())->First()) {
			//parent::redirect('/');
			die('could\'t find member');
		}
		
		//Create our fields
        $fields = new FieldList(
            new TextField('Name', '<span>*</span> Name (or Nickname)'),
            new EmailField('Email', '<span>*</span> Email'),
            new ConfirmedPasswordField('Password', 'New Password')
        );
        
        // Create action
        $actions = new FieldList(
            new FormAction('SaveProfile', 'Save')
        );
        
        // Create action
        $validator = new RequiredFields('FirstName', 'Email');
        
       //Create form
        $Form = new Form($this, 'save', $fields, $actions, $validator);
		
        //Populate the form with the current members data
        $Form->loadDataFrom($member->data());
		
		return $this->renderWith('Profile', array(
			'Form' => $Form,
			'Member' => $member
		)); 
	}

}