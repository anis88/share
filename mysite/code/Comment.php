<?php

class Comment extends DataObject {
	
	static $db = array(
		'Content' => 'HTMLText'
	);
	
	static $has_one = array(
		'Post' => 'Post',
		'Member' => 'Member'
	);
	
	static $summary_fields = array(
		'Post.Title' => 'Title',
		'Member.FirstName' => 'Username'
    );
	
	public function canCreate($member = NULL){ 
		return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
	}
	
	public function canDelete($member = NULL){ 
		if (Permission::check('ADMIN') || $this->MemberID == Member::currentUserID()) { 
			return true;
		}
		return false;
	}
	
	public function canEdit($member = NULL){ 
		if (Permission::check('ADMIN') || $this->MemberID == Member::currentUserID()) { 
			return true;    
		}
		return false;
	}
	
	public function canView($member = null) {
		return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }
	
	public function getGravatarImage($size = 80) {
		return 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($this->Member()->Email))) . '?s=' . $size;
	}

}