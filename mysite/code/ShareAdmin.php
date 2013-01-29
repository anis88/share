<?php

class ShareAdmin extends ModelAdmin {
    
    public static $managed_models = array(
        'Post'
    );
 
    static $url_segment = 'share'; 
    static $menu_title = 'Share';
 
}