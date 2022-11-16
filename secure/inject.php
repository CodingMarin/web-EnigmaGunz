<?php
/**
*/

$xa = getenv('REMOTE_ADDR');
$badwords = array(";","'","\"","*","union","x:","x:\#","delete ","///","from|xp_|execute|exec|sp_executesql|sp_|select|update|set|shutdown|insert|
	            delete|where|drop table|show tables|#|\*|","DELETE","insert",","|"x'; U\PDATE Character S\ET level=99;-\-","x';
	            U\PDATE Account S\ET ugradeid=999;-\-","x';U\PDATE Account D\ROP ugradeid=999;-\-","x';U\PDATE Account D\ROP ",",W\\HERE 1=1;-\\-","z';
	            U\PDATE Account S\ET ugradeid=char","update","drop","sele","memb","set" ,"$","res3t","wareh","%","--","-"); 

foreach($_POST as $value) 
foreach($badwords as $word) 
if(substr_count($value, $word) > 0) 
?>