<?php

  $crlf=chr(13).chr(10);
  $itime=3;  //Minimum number of seconds between one-visitor visits
  $imaxvisit=5;  //Maximum visits in $itime x $imaxvisits seconds
  $ipenalty=($itime * $imaxvisit);  //Minutes for waitting
  $iplogdir="./logs/";
  $iplogfile="AttackersIPs.Log";
  

  
  $to      = 'airgamers_staff@hotmail.com';  
  $headers = 'De: AirGamers GunZ DDOS Attack Shield' . "\r\n";
  $subject = "Advertencia, Posible ataque DDOS, $today:$min:$sec";
  

  //Warning Messages:
  $message1='<font color="red">AirGamers GunZ DDOS Shield ha detectado un DDOS Attack!</font><br>';
  $message2='Espere ... ';
  $message3=' segundos e intente de nuevo.<br>';
  $message4='<font color="blue">Protegido por DDOS Shield by Trinityent.</font><br>Sea paciente.<br>Perdone nuestros inconvenientes, La pagina web de AirGamersGunZ parece estar en una banda ancha o pudo haber sido un ataque DOS, <b>Tu Direccion de ip es: '.$_SERVER["REMOTE_ADDR"].' </b>a sido guardad y enviada a los administradores por causa de seguridad.';
  $message5= 'AirGamers GunZ pudo haber sido atacado con tu ip o puede que este en una banda ancha, Enviaremos tu Direccion de ip por seguridad: '.$_SERVER["REMOTE_ADDR"];
  $message6='<br><img src="./logs/cross.gif" alt="" border="0">'; 
//---------------------- End of Initialization ---------------------------------------  

  //Get file time:
  $ipfile=substr(md5($_SERVER["REMOTE_ADDR"]),-3);  // -3 means 4096 possible files
  $oldtime=0;
  if (file_exists($iplogdir.$ipfile)) $oldtime=filemtime($iplogdir.$ipfile);

  //Update times:
  $time=time();
  if ($oldtime<$time) $oldtime=$time;
  $newtime=$oldtime+$itime;

  //     Check human or bot:
  if ($newtime>=$time+$itime*$imaxvisit)
  {
    //     To block visitor:
    touch($iplogdir.$ipfile,$time+$itime*($imaxvisit-1)+$ipenalty);
    header("HTTP/1.0 503 Service Temporarily Unavailable");
    header("Connection: close");
    header("Content-Type: text/html");
    echo '<html><head><title>Air Gamers GunZ DDOS Shield</title></head><body><p align="center"><strong>'
          .$message1.'</strong>'.$br;
    echo $message2.$ipenalty.$message3.$message4.$message6.'</p></body></html>'.$crlf;
   //     Mailing Warning Message to Site Admin
     {
	@mail($to, $subject, $message5, $headers);	
     }
    //     logging:
    $fp=@fopen($iplogdir.$iplogfile,"a");
    if ($fp!==FALSE)
    {
      $useragent='<unknown user agent>';
      if (isset($_SERVER["HTTP_USER_AGENT"])) $useragent=$_SERVER["HTTP_USER_AGENT"];
      @fputs($fp,$_SERVER["REMOTE_ADDR"].' on '.date("D, d M Y, H:i:s").' as '.$useragent.$crlf);
    }
    @fclose($fp);
    exit();

  }



?>