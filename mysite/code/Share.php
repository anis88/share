<?php

class Share_Controller extends Controller {

	private $per_page;

	public static $allowed_actions = array (
		'like',
		'likes',
		'page',
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
		
		$this->per_page = 3;
		
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
			$js_folder . 'init.js',
			$js_folder . 'soundcloud.js'
		);
		foreach ($js_array as $js) {
			Requirements::javascript($js);
		}
		Requirements::combine_files('scripts.js', $js_array);
		
		// set locale
		if ($member = Member::CurrentUser()) {
			if ($member->Locale != i18n::get_locale()) {
				i18n::set_locale($member->Locale);
			}
		}		
	}
	
	public function index() {	
		$posts = Post::get()->sort('Created', 'DESC');
		
		$list = new PaginatedList($posts, $this->request);
		$list->setPageLength(12);
		
		return $this->renderWith('Share', array(
			'Posts' => $list
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
	
	public function page() {
		$params = $this->getURLParams();
		$page = (int)$params['ID'];
		
		if ($page > 0) {
			$start = ($page - 1) * $this->per_page;
			
			$posts = Post::get()->sort('Created', 'DESC')->limit($this->per_page, $start);
			
			if ($posts->Count() > 0) {
				return $this->renderWith('Share', array(
					'Posts' => $posts
				));	
			} else {
				$this->redirect('/');
			}
		} else {
			$this->redirect('/');
		}
	}
	
	public function post() {
		$params = $this->getURLParams();
		$id = (int)$params['ID'];
		
		$post = Post::get()->filter('ID', $id)->First();
		
		if ( ! $post) {
			$this->redirect('/');
		} else {		
			return $this->renderWith('Post', array(
				'Post' => $post,
				'SoundcloudClientID' => defined('SOUNDCLOUD_CLIENT_ID') ? SOUNDCLOUD_CLIENT_ID : false
			));
		}
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
			$posts = Post::get()->filter('MemberID', $member->ID)->sort('Created', 'DESC');
		} else {
			$posts = false;
		}
		
		return $this->renderWith('Share', array(
			'Posts' => $posts,
			'UserName' => $username
		)); 
	}
	
}