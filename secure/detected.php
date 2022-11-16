<?php
//Script Desenvolvido Por  Fairy e roger

$ip=$_SERVER['REMOTE_ADDR'];

$open = fopen("./ataques.txt","a+");
$quebra = chr(13).chr(10);
fwrite($open,"----------".$quebra);
fwrite($open,"Noob com IP: $ip".$quebra);
fwrite($open,"Tentou Dar SQL Inject".$quebra);
fclose($open);

?>

<script>alert('SQL Injetion Detetectado');</script>
<script>alert('Seu IP Foi Salvo!');</script>

Sistema By:<font color=red>Gaspar</font>

Da Proxima vez pense melhor...