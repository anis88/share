<?php

class Share_Controller extends Controller {

	public static $allowed_actions = array (
		'like',
		'likes',
		'post',
		'search',
		'unlike',
		'user'
	);
	
	public static $url_handlers = array(
        //'posts/user/$ID' => 'user'
    );
	
	public function init() {
		parent::init();
		
		$theme_folder = 'themes/' . SSViewer::current_theme();
		$css_folder = $theme_folder . '/css/';
		$combined_folder = $theme_folder . '/_combinedfiles';
		
		Requirements::set_combined_files_folder($combined_folder);
		
		// include css
		Requirements::css($css_folder . 'foundation/stylesheets/foundation.min.css');
		Requirements::css($css_folder . 'ToolTip.css');
		// TODO pass target folder
		Requirements::css($css_folder . 'app.less', 'screen', BASE_PATH);
		
		// include js
		$js_folder = $theme_folder . '/javascript/';
		
		$js_array = array(
			$js_folder . 'mootools-core-1.4.5-full-nocompat-yc.js',
			$js_folder . 'ToolTip.js',
			$js_folder . 'init.js'
		);
		foreach ($js_array as $js) {
			Requirements::javascript($js);
		}
		Requirements::combine_files('scripts.js', $js_array);
	}
	
	public function index() {
		$posts = Post::get()->sort('Created', 'DESC');
		
		return $this->renderWith('Share', array(
			'Posts' => $posts
		));
	}
	
	public function like() {
		$params = $this->getURLParams();
		$id = (int)$params['ID'];
		
		$like_count = Like::get()->filter(array(
			'PostID' => $id,
			'MemberID' => Member::currentUserID()
		))->Count();
		
		if ($like_count == 0) {
			$like = new Like();
			$like->PostID = $id;
			$like->MemberID = Member::currentUserID();
			$like->write();
		}
	}
	
	public function likes() {
		$params = $this->getURLParams();
		$id = (int)$params['ID'];
		
		// TODO map firstname & exclude current member
		$member = Member::get()->leftJoin('Like', 'Like.MemberID = Member.ID')->filter(array(
			'PostID' => $id
		))->sort('Member.FirstName', 'ASC');
		
		return $this->renderWith('Ajax', array(
			'Member' => $member
		)); 
	}
	
	public function post() {
		$params = $this->getURLParams();
		$id = (int)$params['ID'];
		
		$post = Post::get()->filter('ID', $id)->First();
		
		return $this->renderWith('Post', array(
			'Post' => $post
		)); 
	}
	
	public function search() {
		$params = $this->getURLParams();
		$search_term = $params['ID'];
		
		$posts = Post::get()->filter(array(
			'Title:PartialMatch' => $search_term
		));
		
		return $this->renderWith('Share', array(
			'Posts' => $posts,
			'SearchTerm' => $search_term
		)); 
	}
	
	public function unlike() {
		$params = $this->getURLParams();
		$id = (int)$params['ID'];
		
		$like = Like::get()->filter(array(
			'PostID' => $id,
			'MemberID' => Member::currentUserID()
		))->First();
		
		if ($like) {
			$like->delete();
		}
	}
	
	public function user() {
		$params = $this->getURLParams();
		$username = $params['ID'];
		
		$member = Member::get()->filter('FirstName', $username)->First();
		
		if ($member) {
			$posts = Post::get()->filter('MemberID', $member->ID)->sort('Created');
		} else {
			$posts = false;
		}
		
		return $this->renderWith('Share', array(
			'Posts' => $posts,
			'UserName' => $username
		)); 
	}
	
}