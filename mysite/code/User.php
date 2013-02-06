<?php

class User_Controller extends Share_controller {

	public static $allowed_actions = array (
		'edit',
		'likes',
		'notifications'
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
	
	public function likes() {
		$posts = Post::get()
		         ->leftJoin('Like', 'Like.MemberID = ' . Member::currentUserID() . ' AND Like.PostID = Post.ID')
		         ->where('Like.MemberID > 0')
		         ->sort('Post.Created', 'DESC');
		
		return $this->renderWith('Share', array(
			'LikesPage' => true,
			'Posts' => $posts
		));
	}

}