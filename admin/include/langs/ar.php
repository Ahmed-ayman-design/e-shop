<?php
function lang($phrase){

    static $lang=array(
        'message'=>'اهلا و سهلا',
        'admin'=>'احمد'
    );
    return $lang[$phrase];
}; 