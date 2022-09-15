<?php
function lang($phrase){

    static $lang=array(
        
        'Home Admin'=>'Home ',
        'CATEGORIES'=>'CATEGORIES',
        'ITEMS'=>'ITEMS ',
        'MEMBERS'=>'MEMBERS',
        'COMMENTS'=>'COMMENTS',
        'STATISTIC'=>'STATISTIC',
        'LOGS'=>'LOGS'
        
    );


    return $lang[$phrase];
}; 
