<?php

class ColorAdmin extends ModelAdmin {
    
    public static $managed_models = array(
        'Color'
    );
 
    static $url_segment = 'colors'; 
    static $menu_title = 'Colors';
 
}