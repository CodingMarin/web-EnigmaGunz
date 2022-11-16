<?
include "secure/anti_inject.php";
include "secure/sql_check.php";
if($_SESSION[UserID] <> "")
{
    SetMessage("Mensaje de HeroGamers", array("¡Deslogueate Primero Para Crear Otras Cuentas!"));
    header("Location: index.php");
    die();
}

if(isset($_POST[submit]))
{
    $user           = clean($_POST[userid]);
    $names          = clean($_POST[namea]);
    $pass[0]        = clean($_POST[pass1]);
    $pass[1]        = clean($_POST[pass2]);
    $email          = clean($_POST[email]);
    $sq             = clean($_POST[sq]);
    $sa             = clean($_POST[sa]);

    if($pass[0] != $pass[1]){
        SetMessage("Register", array("The passwords do not match"));
        header("Location: index.php?do=register");
        die();
    }
    elseif ( mssql_num_rows( mssql_query_logged("SELECT * FROM Account(nolock) WHERE UserID = '$user'") ) <> 0 ){
        SetMessage("Register", array("The UserID $userid is already in use"));
        header("Location: index.php?do=register");
        die();
    }
    elseif ( mssql_num_rows( mssql_query_logged("SELECT * FROM Account(nolock) WHERE Email = '$email'") ) <> 0 ){
        SetMessage("Register", array("The Email $email is already in use"));
        header("Location: index.php?do=register");
        die();
    }
    elseif ($user == ""){
        SetMessage("Register", array("Please enter an UserID"));
        header("Location: index.php?do=register");
        die();
    }
    elseif ($pass[0] == "" || $pass[1] == ""){
        SetMessage("Register", array("Please enter a password"));
        header("Location: index.php?do=register");
        die();
    }
    elseif ($email == ""){
        SetMessage("Register", array("Please enter an email"));
        header("Location: index.php?do=register");
        die();
    }
    elseif ($sq == ""){
        SetMessage("Register", array("Please enter a secret question"));
        header("Location: index.php?do=register");
        die();
    }
    elseif ($sa == ""){
        SetMessage("Register", array("Please enter a secret answer"));
        header("Location: index.php?do=register");
        die();
    }
    elseif (strlen($user) < 3){
        SetMessage("Register", array("The userid is too short (6 chars min)"));
        header("Location: index.php?do=register");
        die();
    }
    elseif (strlen($pass[0]) < 3){
        SetMessage("Register", array("The password is too short (6 chars min)"));
        header("Location: index.php?do=register");
        die();
    }
    else{

            $registered = 1;
           mssql_query("INSERT INTO Account (UserID, Name, Email, UGradeID, PGradeID, RegDate, sa, sq, Coins, EventCoins, DonatorCoins)Values ('$user', '$names','$email', 0, 0, GETDATE(), '$sa', '$sq', 0, 0, 0)");
	    $res = mssql_query("SELECT * FROM Account WHERE UserID = '$user'");
	    $usr = mssql_fetch_assoc($res);
	    $aid = $usr['AID'];
          mssql_query("INSERT INTO Login ([UserID], [AID], [Password])Values ('$user', '$aid', '$pass[0]')");
        SetMessage("Register", array("The account $user has been created successfully"));
        header("Location: index.php");
        die();
    }

}else{

/*    $europe = array('DE','AT','BG','BE','CY','DK','SK','SI','ES','EE','FI','FR','GR','HU','IE','LV','LT','LU','MT','NL','PL','PT','GB','CZ','RO','SE');

    $p = GetCountryCodeByIP($_SERVER[REMOTE_ADDR]);
    if(in_array(strtoupper($p), $europe))
    {
        $country = sprintf("[<font color='#00FF00'>%s</font>] %s", $p, GetCountryNameByIP($_SERVER[REMOTE_ADDR]));
    }else{
        $country = sprintf("[<font color='#FF0000'>%s</font>] %s", $p, GetCountryNameByIP($_SERVER[REMOTE_ADDR]));
    }*/
}



?>
<html>
<head>
 <script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "../connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
  <title>EnigmaGamers - Register</title>
  <link rel="shortcut icon" type="image/x-icon" href="images/Enig.ico" />
  <meta name="description" content="Enigma Gamers Free Gunz Server!">
  <meta name="keywords" content="Gunz,The,Duel,Enigma">
  <link rel="stylesheet" type="text/css" href="/style.css"> 
  <!--[if IE 6]>
	<style type="text/css">
		* html .group {
			height: 1%;
		}
	</style>
  <![endif]--> 
  <!--[if IE 7]>
	<style type="text/css">
		*:first-child+html .group {
			min-height: 1px;
		}
	</style>
  <![endif]--> 
  <!--[if lt IE 9]> 
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script> 
  <![endif]--> 
 </head>
 <body>
	
     <div class="putiflan_20160611_214013-holder">
	 <div class="BGHeader"></div></div>
  <div class="global_container_">
    <div class="row group">
     <div class="col-16">
      <div class="acceder-cuenta">
       <p class="text-12"> MEMBER LOGIN</p>
       <div class="row-9 group">
	   	   <form action="index.php?Page=Login" method="post">
        <div class="col-17">
         <input type="text" name="User" style="width:120px;height:20px;font-size:14pt;"></br></br>
         <input type="password" name="Pass" style="width:120px;height:20px;font-size:14pt;">
        </div>

        <div class="tablero-3-holder">
			<input type="image" src="images/tablero_3.png" value="Login" alt="Login">
        </div>
		</form>
	   
       </div>
	   		<a href="register.php">
       <div class="tablero-2-holder">
        CREA TU CUENTA
       </div>
	   </a>
		<a href="login.php">
       <div class="tablero-1-holder">
        RECUPERA TU CONTRASEÑA
       </div>
	   </a>
	         </div>
	  		  <div class="video group">
		   <p class="trailer">
		   <iframe width="211" height="152" src="https://www.youtube.com/embed/uaQ1si-bJAY" frameborder="0" allowfullscreen></iframe>
          </p>
		  </div>      <div class="on-line">
       <div class="col-5">
        <p>Enigma Gamers Status:</p>
        <div class="row-4 group">
         <p class="text-15"><span class="color5da7d6">72</span> jugadores ONLINE</p>
         <p class="operativo">operativo</p>
        </div>
       </div>
      </div>
      <div class="donator-coins-descarga">
	<a href="donate.php">
       <div class="wrapper-3">
        <div class="row-3 group">
         <img class="imagenes-de-coisn" src="images/imagenes_de_coisn.png" alt="" width="48" height="51">
         <div class="col-4">
          <img class="text-16" src="images/como_recargar.png" alt="COMO RECARGAR" width="80" height="17" title="COMO RECARGAR">
          <img class="text-17" src="images/enigma_-_donator_coins.png" alt="ENIGMA - DONATOR COINS" width="121" height="16" title="ENIGMA - DONATOR COINS">
         </div>
        </div>
       </div>	   
	</a>
	
	<a href="downloads.php">
       <div class="wrapper-4">
        <div class="row-2 group">
         <img class="descarga" src="images/descarga.png" alt="" width="43" height="33">
         <div class="col-3">
          <img class="text-18" src="images/cliente_oficial.png" alt="Cliente oficial" width="75" height="24" title="Cliente oficial">
          <img class="text-19" src="images/descargar_enigma_gunz.png" alt="DESCARGAR ENIGMA GUNZ" width="130" height="25" title="DESCARGAR ENIGMA GUNZ">
         </div>
        </div>
       </div>
	   </a>
	         </div>
     </div>
     <div class="col-9">
		   <div class="RegisterBG">
<form action="register.php" method="post">
<input value="" type="text" name="User" style="margin: 212px 260px 0px;width:220px;height:20px;font-size:14pt;">
<input value="" type="password" name="Pass" style="margin: 34px 260px 0px;width:220px;height:20px;font-size:14pt;">
<input value="" type="password" name="RePass" style="margin: 16px 260px 0px;width:220px;height:20px;font-size:14pt;">
<input value="" type="text" name="Email" style="margin: 34px 260px 0px;width:220px;height:20px;font-size:14pt;">
<input value="" type="text" name="ReEmail" style="margin: 16px 260px 0px;width:220px;height:20px;font-size:14pt;">
<input value="" type="text" name="SQuestion" style="margin: 34px 260px 0px;width:220px;height:20px;font-size:14pt;">
<input value="" type="text" name="SAnswer" style="margin: 16px 260px 0px;width:220px;height:20px;font-size:14pt;">
<div style="margin: 32px 260px 0px;width:300px;"><div id="captcha_container_1"><img style="float: left; padding-right: 5px" id="captcha_image" src="/SecureImage/securimage_show42d6.png?0c204aab28891ec4cb1ddcf049a32c48" alt="CAPTCHA Image" /><div id="captcha_image_audio_div">
<audio id="captcha_image_audio" preload="none" style="display: none">
<source id="captcha_image_source_wav" src="/SecureImage/securimage_audio-2.wav" type="audio/wav">
<object type="application/x-shockwave-flash" data="/SecureImage/securimage_play7b7d.swf?bgcol=%23ffffff&amp;icon_file=%2FSecureImage%2Fimages%2Faudio_icon.png&amp;audio_file=%2FSecureImage%2Fsecurimage_play.php%3F" height="32" width="32"><param name="movie" value="/SecureImage/securimage_play7b7d.swf?bgcol=%23ffffff&amp;icon_file=%2FSecureImage%2Fimages%2Faudio_icon.png&amp;audio_file=%2FSecureImage%2Fsecurimage_play.php%3F" /></object><br /></audio>
</div>
<div id="captcha_image_audio_controls">
<a tabindex="-1" class="captcha_play_button" href="/SecureImage/securimage_audio-1.wav" onClick="return false">
<img class="captcha_play_image" height="32" width="32" src="/SecureImage/audio_icon.png" alt="Play CAPTCHA Audio" style="border: 0px">
<img class="captcha_loading_image rotating" height="32" width="32" src="/SecureImage/images/loading.png" alt="Loading audio" style="display: none">
</a>
<noscript>Enable Javascript for audio controls</noscript>
</div>
<script type="text/javascript" src="/SecureImage/securimage.js"></script>
<script type="text/javascript">captcha_image_audioObj = new SecurimageAudio({ audioElement: 'captcha_image_audio', controlsElement: 'captcha_image_audio_controls' });</script>
<a tabindex="-1" style="border: 0" href="#" title="Refresh Image" onClick="if (typeof window.captcha_image_audioObj !== 'undefined') captcha_image_audioObj.refresh(); document.getElementById('captcha_image').src = '/SecureImage/securimage_showd1.png' + Math.random(); this.blur(); return false"><img height="32" width="32" src="/SecureImage/images/refresh.png" alt="Refresh Image" onClick="this.blur()" style="border: 0px; vertical-align: bottom" /></a><br /><div style="clear: both"></div><label for="captcha_code"></label> </br><input type="text" name="ct_captcha" id="captcha_code" style="width:220px;height:20px;font-size:14pt;" /></div></div>	  <input type="submit" value="Register" style="margin: 26px 260px 0px;width:200px;height:20px;font-size:14pt;">
</div>
     </div>
	      </div>
    <div class="barra-texturas">
     <div class="barra-tracera-holder">
      <img class="textura" src="/images/textura.jpg" alt="" width="981" height="28">
     </div>
     <img class="barra-tracera-abajo" src="/images/barra_tracera_abajo.jpg" alt="" width="564" height="40">
     <img class="barra-tracera-alta" src="/images/barra_tracera_alta.png" alt="" width="491" height="38">
     <div class="barra-delantera-holder">
      <div class="textura-holder" height="40">
	  <a href="index.php"><div class="HomeH"></div></a>
	  <a href="register.php"><div class="RegisterH"></div></a>
	  <a href="downloads.php"><div class="DownloadH"></div></a>
	  <a href="ranking.php"><div class="RankingH"></div></a>
	  <a href="shop.php"><div class="ShopH"></div></a>
	  <a href="http://forum.enigmagamerz.com/"><div class="ForumH"></div></a>
         </div>
     </div>
    </div>
   </div>
  </div>
 </body>

<!-- Mirrored from 104.238.223.59/register.php by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 08 Sep 2016 04:13:12 GMT -->
</html>