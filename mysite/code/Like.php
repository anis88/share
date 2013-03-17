<?php

class Like extends DataObject {
	
	static $has_one = array(
		'Post' => 'Post',
		'Member' => 'Member'
	);

}