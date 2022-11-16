<?
//Anti SQL injection.
function antisql($value)
{
        $check = $value;

        $value = preg_replace(sql_regcase("/(from|select|update|account|login|clan|character|indexcontent|set|insert|delete|where|drop table|show tables|#|\*|--|\\\\|-)/"),"",$value);
        $value = trim($value);
        $value = strip_tags($value);
        $value = addslashes($value);
        $value = str_replace("'", "''", $value);

        if( $check != $value )
        {
            $logf = fopen("logs/sqllog.txt", "a+");
            fprintf($logf, "Date: %s - IP: %s - Código: %s, - Correto: %s\r\n", date("d-m-Y h:i:s A"), $_SERVER['REMOTE_ADDR'], $check, $value );
            fclose($logf);
        }

        return( $value );
}
?>