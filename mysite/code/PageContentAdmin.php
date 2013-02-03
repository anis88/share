<?php

class PageContentAdmin extends ModelAdmin {
    
    public static $managed_models = array(
        'PageContent'
    );
 
    static $url_segment = 'content'; 
    static $menu_title = 'Page Content';
 
}