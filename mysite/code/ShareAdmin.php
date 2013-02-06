<?php

class ShareAdmin extends ModelAdmin {
    
    public static $managed_models = array(
        'Color',
		'Genre',
		'PageContent'
    );
 
    static $url_segment = 'shareadmin'; 
    static $menu_title = 'Admin';
 
}