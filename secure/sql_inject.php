<?php
/**
Dont Remove this
the perfect defense for 2010, the Venix/X1478--
*/

$xa = getenv('REMOTE_ADDR');
$badwords = array(";","'","\"","*","union","x:","x:\#","delete ","///","from|xp_|execute|exec|sp_executesql|sp_|select| insert|delete|where|drop table|show tables|#|\*|","DELETE","insert",","|"x'; U\PDATE Character S\ET level=99;-\-","x';U\PDATE Account S\ET ugradeid=255;-\-","x';U\PDATE Account D\ROP ugradeid=255;-\-","x';U\PDATE Account D\ROP ",",W\\HERE 1=1;-\\-","z'; U\PDATE Account S\ET ugradeid=char","update","drop","sele","memb","set" ,"$","res3t","wareh","%","--"); 

foreach($_POST as $value) 
foreach($badwords as $word) 
if(substr_count($value, $word) > 0) 
die("<script>alert('SQL Inject Detectedo No Podras Injectar'); location='javascript:history.back()'</script>");
?>