<?php

class Post extends DataObject {

	public static $default_sort = 'Created DESC';

    static $db = array(
		'Content' => 'HTMLText',
		'Title' => 'Varchar(100)',
		'YouTubeLink' => 'Varchar(100)'
    );
	
	static $has_one = array(
		'File' => 'File',
		'Member' => 'MyMember'
	);
	
	static $has_many = array(
		'Likes' => 'Like'
	);
	
	static $summary_fields = array(
        'Title',
		'Member.FirstName'
    );
	
	public function canCreate($member = NULL){ 
		return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
	}
	
	public function canDelete($member = NULL){ 
		if (Permission::check('ADMIN')) {
			return true;
		} else {
			if ($this->MemberID == Member::currentUserID()) { 
			    return true;    
			}
			return false;
		} 
	}
	
	public function canEdit($member = NULL){ 
		if (Permission::check('ADMIN')) {
			return true;
		} else {
			if ($this->MemberID == Member::currentUserID()) { 
			    return true;    
			}
			return false;
		}
	}
	
	public function canView($member = null) {
		if (Permission::check('ADMIN')) {
			return true;
		} else {
			if ($this->MemberID == Member::currentUserID())	{
				return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
			}
			return false;
		}
    }
	public function getCMSFields() {
		return new FieldList(
			new TextField('Title'),
			new HTMLEditorField('Content'),
			new UploadField('File'),
			new TextField('YouTubeLink')
		);
	}
	
	public function getLikes() {
		return $this->Likes()->Count();
		//return Like::get()->filter('PostID', $this->ID);
	}
	
	public function getYouTubeID() {
		$link = $this->YouTubeLink;
		// link with ?|&v=ID
		if (strrpos($link, 'v=')) {
			preg_match('/.*v=([A-Za-z0-9]*)/', $link, $match);
			return $match[1];
		}
		// embed link http://youtu.be/ID
		if (strrpos($link, 'youtu.be')) {
			preg_match('/.*youtu.be\/([A-Za-z0-9]*)/', $link, $match);
			return $match[1];
		}
		return false;
	}
	
	public function onBeforeWrite() {	
		if ( ! $this->MemberID) {
			$this->MemberID = Member::currentUserID();
		}
		
		parent::onBeforeWrite();
	}
	
	public function validate() {
        $result = parent::validate();
		
		//if($this->Title == '') {
		//	$result->error('Bitte einen Titel angeben');
		//}
		
        return $result;
    }

}