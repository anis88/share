<?php
class MyMember extends Member {
	
	static $db = array(
		'HideInList' => 'Boolean'
	);
	
	static $has_one = array(
		'Color' => 'Color'
	);
	
	static $has_many = array(
		'Posts' => 'Post'
	);
	
}