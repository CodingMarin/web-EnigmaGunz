<?php
include "config.php";
?>
<?php
$ip = ''.($_SERVER['REMOTE_ADDR']);
?>
<?php
$query = mssql_query("SELECT * FROM Account WHERE UgradeID = 253");
if (mssql_num_rows($query) == 1)
{
include "owned.php";
exit();
}
?>