<?
function mssql_query_logged($query)
{

   
    return mssql_query($query);
}

if(!function_exists("SetMessage") )
{
function SetMessage($title, $Elements)
{
    $output = "<tr><td width='10'>&nbsp;</td>
            <td width='778'>&nbsp;</td>
            <td width='12'>&nbsp;</td>
          </tr>
        	<tr>
            <td width='10'>&nbsp;</td>
            <td width='778'>
			<div align='center'>
				<table border='1' style='border-collapse: collapse' width='100%' bordercolor='#000000'>
					
											<tr>
						<td style='background-image: url(images/content_bar.jpg); background-repeat: repeat-x; background-position-y: top' height='24'>
						<div align='center'><b><font face='Tahoma' size='2'>
						Mensaje de Radiality Gunz</font></b></div></td>
					</tr>
					<tr>
						<td bgcolor='#2C2A2A'>
						<div align='center'>
							<table border='0' style='border-collapse: collapse' width='774' height='100%'>
								<tr>
									<td width='10'>&nbsp;</td>
									<td width='747'>&nbsp;</td>
									<td width='11'>&nbsp;</td>
								</tr>
								<tr>
									<td width='10'>&nbsp;</td>
									<td width='747' align='left'><b>
									<font face='Tahoma' size='2'>$title</font></b></td>
									<td width='11'>&nbsp;</td>
								</tr>
								<tr>
									<td width='10'>&nbsp;</td>
									<td width='747' align='left'>&nbsp;</td>
									<td width='11'>&nbsp;</td>
								</tr>
								<tr>
									<td width='10'>&nbsp;</td>
									<td width='747' align='left'>
						            <ul>";
                                        foreach($Elements as $value)
                                        {
							                $output.= "<li>" . $value . "</li>";
                                        }
						            $output.="</ul>
									</td>
									<td width='11'>&nbsp;</td>
								</tr>
								<tr>
									<td width='10'>&nbsp;</td>
									<td width='747'>&nbsp;</td>
									<td width='11'>&nbsp;</td>
								</tr>
							</table>
						</div>
						</td>
					</tr>
				</table>
			</div>
			</td>
            <td width='12'>&nbsp;</td></tr><tr><td width='10'>&nbsp;</td></tr>";
            $_SESSION[SiteMessage] = $output;
}}

if(!function_exists("re_dir") )
{
function re_dir($url)
{
    echo "<body  bgcolor='#000000'><script>document.location = '$url'</script></body>";
    die("Javascript disabled");
} }

function clean($sql)
{
$sql = preg_replace(sql_regcase("/(from|select|update|account|login|clan|character|indexcontent|set|insert|delete|where|drop table|show tables|#|\*|--|\\\\|-)/"),"",$sql);
$sql = trim($sql);
$sql = strip_tags($sql);
$sql = addslashes($sql);
return $sql;
}

if(!function_exists("msgbox")){
function msgbox($text, $url)
{
    echo "<body  bgcolor='#000000'><script>alert('$text');document.location = '$url'</script></body>";
    die("Javascript disabled");
} }

function SetTitle($title)
{
    $_SESSION[PageTitle] = $title;
}

function GetClanMasterByCLID($clid)
{
    $clanid = clean($clid);

    $res2 = mssql_query("SELECT ch.Name FROM Character(nolock) ch INNER JOIN Clan(nolock) cl ON ch.CID = cl.MasterCID WHERE cl.CLID = '$clanid'");

    $char = mssql_fetch_row($res2);


    return $char[0];
}

function GetCharNameByCID($cid)
{
    $ncid = clean($cid);
    $a = mssql_fetch_assoc(mssql_query("SELECT Name FROM Character(nolock) WHERE CID = '$ncid'"));
    return $a[Name];
}


function CheckIfExistClan($aid){
    $aid = clean($aid);
    $a = mssql_query("SELECT * FROM Character(nolock) WHERE AID = '$aid'");
    if( mssql_num_rows($a) > 0 )
    {
        while($char = mssql_fetch_assoc($a))
        {
            if(mssql_num_rows(mssql_query("SELECT * FROM Clan(nolock) WHERE MasterCID = '".$char[CID]."'")) == 1)
            {
                return true;
                break;
            }
        }
    }
    return false;
}

    function CheckIPBan()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $query = mssql_query("SELECT IPBID FROM IPBans WHERE IP = '$ip' AND Opened = 1");

        if( mssql_num_rows($query) != 0 )
        {
            SetMessage("Banned IP", array("El acceso a Radiality Gunz está prohibido pora su dirección IP"));
            if( $_SESSION['IPBanCheck'] != 1 )
            {
                $_SESSION['IPBanCheck'] = 1;
                header("Location: index.php");
                die();
            }
            else
            {
                $_SESSION['IPBanCheck'] = 0;
            }
        }
    }

                    function CheckIsBanned()
                    {
                        if( $_SESSION[AID]!= "" )
                        {
                            $query001 = mssql_query("
                                            SELECT ac.UGradeID, ac.USerID, ab.BanReason, ab.BanDate FROM Account(nolock) ac
                                            INNER JOIN AccountBan(nolock) ab ON ac.AID = ab.AID
                                            WHERE ab.AID = '{$_SESSION[AID]}' AND ab.Opened = 1");
                            if( mssql_num_rows($query001) != 0 ){
                                $data = mssql_fetch_row($query001);
                                if ($data[0] == 253){
                                    SetMessage("Cuenta Baneada", array("Tu Cuenta ".$data[1]." ha sido baneada", "Razón: ".$data[2], "Fin Del Ban: ".$data[3]));
                                    if( $_SESSION['Banchecked'] != 1 ){
                                        $_SESSION['Banchecked'] = 1;
                                        header("Location: index.php");
                                        die();
                                    }else{
                                        $_SESSION['Banchecked'] = 0;
                                    }

                                }
                            }
                        }
                    }

                    function VerifyChecks()
                    {
                        if( $_SESSION['AID']!= "" )
                        {
                            if( $_GET['do'] != "newpassword" && $_GET['do'] != "confirmrules" )
                            {
                                $query001 = mssql_query("SELECT PassChanged, RulesCheck FROM Login(nolock) WHERE AID = '{$_SESSION[AID]}'");
                                $data001 = mssql_fetch_row($query001);

                                if( $data001[0] != 1 )
                                {
                                    header("Location: index.php?do=newpassword");
                                    die();
                                }
                                elseif( $data001[1] != 1 )
                                {
                                    header("Location: index.php?do=confirmrules");
                                    die();
                                }
                            }
                        }
                    }


function GetCountryCodeByIP($ipaddress)
{
/*    $res = mssql_fetch_assoc(mssql_query_logged("SELECT * FROM IPToCountry WHERE IPTo >= dbo.inet_aton('$ipaddress') AND IPFrom <= dbo.inet_aton('$ipaddress') LIMIT 0,1"));
    return $res[CountryCode2];*/
}

function GetCountryNameByIP($ipaddress)
{
/*    $res = mssql_fetch_assoc(mssql_query_logged("SELECT TOP 1 * FROM IPToCountry WHERE IPTo >= dbo.inet_aton('$ipaddress') AND IPFrom <= dbo.inet_aton('$ipaddress')"));
    return ucfirst(strtolower($res[CountryName]));*/
}

function IsEuropean()
{
    /*$europe = array('DE','AT','BG','BE','CY','DK','SK','SI','ES','EE','FI','FR','GR','HU','IE','LV','LT','LU','MT','NL','PL','PT','GB','CZ','RO','SE');

    $p = GetCountryCodeByIP($_SERVER[REMOTE_ADDR]);
    if(in_array(strtoupper($p), $europe))
    {
        return true;
    }else{
        return false;
    }*/
}

function MakePercent($Value, $Total)
{
    return ($Value * $Total) / 100;
}

function GetClanPercent($Wins, $Losses)
{
    $total = $Wins + $Losses;

    return ($total == 0) ? "0%" : round((100 * $Wins) / $total, 2) . "%";
}

function FormatCharName($cid)
{
    $ncid = clean($cid);
    $res = mssql_fetch_row(mssql_query("SELECT ac.UGradeID, ch.Name From Character(nolock) ch INNER JOIN Account ac ON ac.AID = ch.AID WHERE ch.CID = '$ncid'"));

    $name = $res[1];

    switch($res[0])
    {
        case 255:
            return "<font color='#ff0000'>$name</font>";
        break;
        case 119:
            return "<font color='#7700ff'>$name</font>";
        break;
		case 208:
            return "<strike><font color='#ff00d0'>$name</font></strike>";
        break;
		 case 16:
            return "<font color='#1000ff'>$name</font>";
        break;
		case 250:
            return "<font color='#faff00'>$name</font>";
        break;
		case 72:
            return "<font color='#ff4800'>$name</font>";
        break;
		case 197:
            return "<font color='#c509f9'>$name</font>";
        break;
		case 9:
            return "<font color='#c509f9'>$name</font>";
        break;
		case 249:
            return "<font color='#c509f9'>$name</font>";
        break;
		case 34:
            return "<font color='#22ce08'>$name</font>";
        break;
		case 206:
            return "<font color='#22ce08'>$name</font>";
        break;
		case 8:
            return "<font color='#22ce08'>$name</font>";
        break;
		case 254:
            return "<font color='#ff007b'>$name</font>";
        break;
		case 157:
            return "<font color='#009dff'>$name</font>";
        break;
		case 0:
            return "<font color='#ffffff'>$name</font>";
        break;
        default:
            return $name;
        break;
    }
}

function GetKDRatio($kills, $deaths)
{
    $total = $kills + $deaths;

    $percent = @round((100 * $kills) / $total, 2);

    if($kills == 0 && $deaths == 0)
    {
        return "0/0 (100%)";
    }else{
        return sprintf("%d/%d (%d%%)", $kills, $deaths, $percent);
    }
}

function SetURL($url)
{
    $_SESSION[URL] = $url;
}

function GetSexByID($sid)
{
    switch($sid)
    {
        case 0:
            return "Hombre";
        break;
        case 1:
            return "Mujer";
        break;
        case 2:
            return "Todos";
        break;
    }
}

function GetTypeByID($tid)
{
    switch($cat)
    {
        case 3:
            $type = "Armor";
        break;
        case 2:
            $img = "content_title_shop_meleewea.jpg";
            $type = "Melee";
        break;
        case 1:
            $img = "content_title_shop_rangedwe.jpg";
            $type = "Ranged";
        break;
        case 5:
            $img = "content_title_shop_speciali.jpg";
            $type = "Special";
        break;
        default:
            $img = "content_title_shop_armor.jpg";
            $type = "Armor";
        break;
    }

    return $type;
}


function UploadFTPFile($filename, $host, $user, $pass, $remotefile)
{
    $ftp = ftp_connect($host, 21, 30);

    if(!ftp_login($ftp, $user, $pass))
        return false;

    if(!ftp_pasv($ftp, false))
        return false; 

    //@ftp_delete($ftp, $remotefile);

    if(!ftp_put($ftp, $remotefile, $filename, FTP_BINARY))
        return false;
    else
        ftp_close($ftp);
        return true;
}

function GetImageByType($ntype)
{
    if(substr($ntype, 0, 6) == "[NEWS]")
    {
        return "btn_news.jpg";
    }else{
        return "btn_update.jpg";
    }
}

function DeleteType($ptitle)
{
    if( str_replace(']', '', $ptitle) != $ptitle )
    {
        $titulo = explode(']', $ptitle);
        if (strlen($titulo[1]) <= 25)
        {
            return $titulo[1];
        }
        else
        {
            $titulon = substr( $titulo[1], 0, 25 );
            return $titulon."...";
        }
    }
    else
    {
        if (strlen($ptitle) <= 25)
        {
            return $ptitle;
        }
        else
        {
            $titulon = substr( $ptitle, 0, 25 );
            return $titulon."...";
        }
    }
}

function get_file_extension($filename)
{
    $path_info = pathinfo($filename);
    return $path_info['extension'];
}

function FormatCharNameclanadmin($name, $rank)
{
    switch($rank)
    {
        case 0:
            return $name;
        break;
        case 2:
            return "<font color='#03e29f'>$name</font>";
        break;
        case 104:
            return "<font color='#525252'>$name</font>";
        break;
        case 252:
            return "<font color='#33CC00'>$name</font>";
        break;
        case 253:
            return "<strike><font color='#000000'>$name</font></strike>";
        break;
        case 254:
            return "<font color='#de9201'>$name</font>";
        break;
        case 255:
            return "<font color='#01d3e0'>$name</font>";
        break;
        default:
            return "<font color='4C0094'>$name</font>";
        break;
    }
}  

?>