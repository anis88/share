<?php
class MyMember extends Member {
	
	static $has_one = array(
		'Color' => 'Color'
	);
	
}