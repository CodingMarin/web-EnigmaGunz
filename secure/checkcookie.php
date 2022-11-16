<?php

if(!$_COOKIE['NighTLogin_usr'] == ""){

    $user = clean($_COOKIE['NighTLogin_usr']);
    $md5pass = $_COOKIE['NighTLogin_pwd'];
    $res = mssql_query_logged("SELECT * FROM Login WHERE UserID = '$user'");
    $data = mssql_fetch_assoc($res);
    //
    if(md5("NighTc_".$data['Password']) == $md5pass){
        $_SESSION['AID'] =  $data['AID'];
        $_SESSION['UserID'] = ucfirst($user);
        $_SESSION['Coins'] = $data['Coins'];
        $_SESSION['EVCoins'] = $data['EVCoins'];
        //---
        $res2 = mssql_query_logged("SELECT * FROM Account WHERE AID = '".$data['AID']."'");
        $aData = mssql_fetch_assoc($res2);
        //---
        $_SESSION['UGradeID'] = $aData['UGradeID'];
    }
}
?>