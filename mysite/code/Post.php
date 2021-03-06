<?php

class Post extends DataObject {

	public static $default_sort = 'Created DESC';

    static $db = array(
		'Content' => 'HTMLText',
		'DailyMotionID' => 'Varchar(30)',
		'Title' => 'Varchar(100)',
		'Link' => 'Varchar(250)',
		'VimeoID' => 'Varchar(20)',
		'YouTubeID' => 'Varchar(20)'
    );
	
	static $has_one = array(
		'File' => 'File',
		'Genre' => 'Genre',
		'Member' => 'MyMember'
	);
	
	static $has_many = array(
		'Comments' => 'Comment',
		'Likes' => 'Like'
	);
	
	static $summary_fields = array(
        'Title' => 'Title',
		'Genre.Title' => 'Genre',
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
		if (Permission::check('ADMIN') || $this->MemberID == Member::currentUserID())	{
			return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
		}
		return false;
    }
	
	public function getCMSFields() {
		$dropdown_values = Genre::get()->map('ID', 'Title');
		
		return new FieldList(
			new TextField('Title'),
			new HTMLEditorField('Content', 'Text'),
			new DropdownField('GenreID', 'Genre', $dropdown_values, 0, null, '-- select genre --'),
			// adjust the max upload size to your server settings
			new UploadField('File', 'File (max. 16MB)'),
			new TextField('Link', 'Youtube, Soundcloud, Vimeo or Dailymotion Link')
		);
	}

	public function getDailyMotionID() {
		$elements = explode('/', $this->Link);
		$id_raw = explode('_', end($elements));
		if (is_array($id_raw)) {
			return $id_raw[0];
		}
		return false;
	}
	
	public function getLikes() {
		return Member::get()
		       ->leftJoin('Like', 'Like.MemberID = Member.ID')
		       ->where('Like.PostID = ' . $this->ID)
		       ->exclude('ID', Member::currentUserID());
	}
	
	public function getPostsInGenre() {
		return Post::get()
		       ->filter('GenreID', $this->GenreID)
		       ->exclude('ID', $this->ID)
		       ->limit(5)
		       ->sort('RAND()');
	}
	
	public function getVimeoID() {
		// embed link http://vimeo.com/ID
		if (strrpos($this->Link, 'vimeo.com')) {
			preg_match('/.*vimeo.com\/([^?]*)/', $this->Link, $match);
			return $match[1];
		}
		
		return false;
	}
	
	public function getYouTubeID() {
		// link with ?|&v=ID
		if (strrpos($this->Link, 'v=')) {
			preg_match('/.*v=([^&]*)/', $this->Link, $match);
			return $match[1];
		}
		// embed link http://youtu.be/ID
		if (strrpos($this->Link, 'youtu.be')) {
			preg_match('/.*youtu.be\/([^?]*)/', $this->Link, $match);
			return $match[1];
		}
		
		return false;
	}
	
	public function hasLiked() {
		return Like::get()->filter(array(
			'MemberID' => Member::currentUserID(),
			'PostID' => $this->ID
		))->First();
	}
	
	public function hasDailyMotionID() {
		return strrpos($this->Link, 'dailymotion');
	}
	
	public function hasSoundcloudLink() {
		return strrpos($this->Link, 'soundcloud.com');
	}
	
	public function hasVimeoID() {
		return $this->VimeoID;
	}
	
	// useless helper...Post.YouTubeID is true in the template even if NULL
	public function hasYouTubeID() {
		return $this->YouTubeID;
	}
	
	public function onBeforeWrite() {	
		if ( ! $this->MemberID) {
			$this->MemberID = Member::currentUserID();
		}
		// stores extracted vimeo id if available
		if (preg_match('/vimeo/', $this->Link)) {
			$this->VimeoID = $this->getVimeoID();
		}
		// stores extracted youtube id if available
		elseif (preg_match('/youtu(.)?be/', $this->Link)) {
			$this->YouTubeID = $this->getYouTubeID();
		}
		// stores extracted Dailymotion ID if available
		elseif (preg_match('/dailymotion/', $this->Link)) {
			$this->DailyMotionID = $this->getDailyMotionID();
		}
		
		parent::onBeforeWrite();
	}
	
	/*
	public function validate() {
        $result = parent::validate();
		
        return $result;
    }
	*/

}