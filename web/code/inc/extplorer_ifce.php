<?php

define('LEARNING_RESOURCES_DIR', '/Users/zhang/tmp/qui_files');

$GLOBALS["users"]=array(
    // array('admin','21232f297a57a5a743894a0e4a801fc3','/Users/zhang/tmp/qui_files','http://localhost','1','','7',1),
);

if(isset($GLOBALS['oj_user'])){
    if(isset($GLOBALS['oj_administrator']))
        $p='1';
        // $p='7';
    else
        $p='0';
    array_push($GLOBALS["users"], 
        array($_SESSION['user'],'7c2310f49b45203bf5e4ddc2a12c94da',LEARNING_RESOURCES_DIR,'http://localhost','1','',$p,1)
    );
}
