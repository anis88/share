<?php

class Share_Controller extends Controller {

	private $per_page;

	public static $allowed_actions = array (
		'comment',
		'like',
		'likes',
		'newpost',
		'page',
		'post',
		'savepost',
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
			$js_folder . 'third-party/jquery-1.9.1.min.js',
			$css_folder . 'foundation/javascripts/modernizr.foundation.js',
			$css_folder . 'foundation/javascripts/app.js',
			$css_folder . 'foundation/javascripts/jquery.foundation.forms.js',
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
		
		return $this->renderWith(array('Page', 'Share'), array(
			'Posts' => $list
		));
	}
	
	public function comment() {
		$params = $this->getURLParams();
		$id = (int)$params['ID'];
		
		if ( ! Member::currentUserID()) return false;
		
		$postVars = $this->request->postVars();
		$text = trim($postVars['Text']);
		
		if ($text == '') return false;
		
		$comment = new Comment();
		$comment->Content = $this->nl2p($text);
		$comment->PostID = $id;
		$comment->MemberID = Member::currentUserID();
		$comment->write();
		
		header('Content-type: application/json');
		echo json_encode(array(
			'Comment' => array(
				'Content' => $comment->Content,
				'Image' => $this->getGravatarImageForCurrentMember(60),
				'Member' => $comment->Member()->FirstName,
				'Created' => 'just now'
			)
		));
	}
	
	public function getGravatarImageForCurrentMember($size = 40) {
		return 'http://www.gravatar.com/avatar/' . md5(strtolower(trim(Member::CurrentUser()->Email))) . '?s=' . $size;
	}
	
	public function like() {
		$params = $this->getURLParams();
		$id = (int)$params['ID'];
		
		if ( ! Member::currentUserID()) return false;
		
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
	
	public function newpost() {
		if ( ! Member::currentUserID()) $this->redirect('/');
		
		$genres = Genre::get();
		
		return $this->renderWith(array('Page', 'NewPost'), array(
			'Genres' => $genres
		));
	}
	
	private function nl2p($string, $line_breaks = true, $xml = true) {

		$string = str_replace(array('<p>', '</p>', '<br>', '<br />'), '', $string);
		
		// It is conceivable that people might still want single line-breaks
		// without breaking into a new paragraph.
		if ($line_breaks == true) {
			return '<p>'.preg_replace(array("/([\n]{2,})/i", "/([^>])\n([^<])/i"), array("</p>\n<p>", '$1<br'.($xml == true ? ' /' : '').'>$2'), trim($string)).'</p>';
		}
		else {
			return '<p>'.preg_replace(
			array("/([\n]{2,})/i", "/([\r\n]{3,})/i","/([^>])\n([^<])/i"),
			array("</p>\n<p>", "</p>\n<p>", '$1<br'.($xml == true ? ' /' : '').'>$2'),
		
			trim($string)).'</p>';
		}
	}
	
	public function post() {
		$params = $this->getURLParams();
		$id = (int)$params['ID'];
		
		$post = Post::get()->filter('ID', $id)->First();
		
		if ($post) {
			return $this->renderWith(array('Page', 'Post'), array(
				'Post' => $post,
				'SoundcloudClientID' => defined('SOUNDCLOUD_CLIENT_ID') ? SOUNDCLOUD_CLIENT_ID : false
			));
		} else {
			$this->redirect('/');
		}
	}
	
	public function savepost() {
		if ( ! Member::currentUserID() || ! Director::is_ajax()) {
			exit;
		}
		
		// retrieve and validate data
		$postVars = $this->request->postVars();
		$title = $postVars['Title'];
		$text = $this->nl2p($postVars['Text']);
		$genre = $postVars['Genre'];
		$link = $postVars['Link'];
		
		$post = new Post();
		$post->Title = $title;
		$post->Content = $text;
		$post->GenreID = (int)$genre > 0 ? $genre : NULL;
		$post->Link = $link;
		$post->MemberID = Member::currentUserID();
		$post->write();
		
		header('Content-type: application/json');
		if ($post) {
			echo json_encode(array('success' => array('ID' => $post->ID)));
		} else {
			echo json_encode(array('error'));
		}
	}
	
	public function search() {
		$params = $this->getURLParams();
		$search_term = $params['ID'];
		
		$posts = Post::get()->filter(array(
			'Title:PartialMatch' => $search_term
		));
		
		return $this->renderWith(array('Page', 'Share'), array(
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
		
		return $this->renderWith(array('Page', 'Share'), array(
			'Posts' => $posts,
			'UserName' => $username
		)); 
	}
	
}