<?
function iteminfo($_item,$type=1)
{
if ((strlen($_item)!=32) || (!ereg("(^[a-zA-Z0-9])",$_item)) || ($_item == 'FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF')) return false;
	// Get the hex contents
	$sy 	= hexdec(substr($_item,0,2)); 	// Item ID
	$iop 	= hexdec(substr($_item,2,2)); 	// Item Level/Skill/Option Data
	$itemdur= hexdec(substr($_item,4,2)); 	// Item Durability
	$ItemSerial	= substr($_item,6,8);		// Item SKey
	$ioo 	= hexdec(substr($_item,14,2)); 	// Item Excellent Info/ Option
	$ac	= hexdec(substr($_item,16,2)); 	// Ancient data
	$itt 	= hexdec(substr($_item,18,2)); 	// Item Type
	$mix 	= hexdec(substr($_item,19,2)); 	// 380 Mixed Item Option
	$harmony 	= hexdec(substr($_item,21,1)); 	// Harmony Item Option
	$itemtype = $itt/16;
	// The ancient types with no set options
	if ($ac==4) 
		$ac=5;
	if ($ac==9) 
		$ac=10;
	// Debug
	switch ($itemtype) {
		case 0.5:
			$itemtype=0;
			break;
		case 2.5:
			$itemtype=2;
			break;		
		case 4.5:
			$itemtype=4;
			break;	
		case 5.5:
			$itemtype=5;
			break;				
		case 7.5:
			$itemtype=7;
			break;				
		case 8.5:
			$itemtype=8;
			break;				
		case 9.5:
			$itemtype=9;
			break;				
		case 10.5:
			$itemtype=10;
			break;				
		case 11.5:
			$itemtype=11;
			break;				
		case 12:
			$itemtype=14;
			break;
		case 13:
			$itemtype=12;
			break;
		case 14:
			$itemtype=13;
			break;
	}
	// Skill Check
	if ($iop<128) 
		$skill	= '';
	else {
		$skill	= 'Esta arma tiene un Skill Especial';
		$iop	= $iop-128;
	}
	// Item Level Check
	$itemlevel	= floor($iop/8);
	$iop		= $iop-$itemlevel*8;
	// Luck Check
	if($iop<4)
		$luck	= ''; 
	else {
		$luck	= "Suerte (Exito de la Jewel of Soul +25%)<br>Suerte (Dmg Critico +5%)";
		$iop	= $iop-4;
	}
	// Excellent option check
	if($ioo>=64)	{ $iop+=4; $ioo+=-64; }
	if($ioo<32)	{ $iopx6=0; } else { $iopx6=1; $ioo+=-32; }
	if($ioo<16)	{ $iopx5=0; } else { $iopx5=1; $ioo+=-16; }
	if($ioo<8)	{ $iopx4=0; } else { $iopx4=1; $ioo+=-8; }
	if($ioo<4)	{ $iopx3=0; } else { $iopx3=1; $ioo+=-4; }
	if($ioo<2)	{ $iopx2=0; } else { $iopx2=1; $ioo+=-2; }
	if($ioo<1)	{ $iopx1=0; } else { $iopx1=1; $ioo+=-1; }

	$fquery		= mssql_query("select * from [WebShop] where [id]=".$sy." and [type]=".$itemtype." and [stickLevel]=".$itemlevel);
	if (mssql_num_rows($fquery)<1)
	{
		$fquery	= mssql_query("select * from [WebShop] where [id]=".$sy." and [type]=".$itemtype);
		$nolevel= 0;
	}
	else 
		$nolevel=1;

	$fresult	= mssql_fetch_array($fquery);	
	$iopxltype	= $fresult['ex_type'];
	$itemname	= $fresult['name'];
	// Case that item is not found -> stop the proccess
	if (!$fresult) 
		return false;

$mixed ='';
	switch($itemtype) 
	{
	case 0:
		$mixitemopt ='<br>Additional damage +200<br>Attack success rate increase +10<br>';
	break;
	case 2:
		$mixitemopt ='<br>Additional damage +200<br>Attack success rate increase +10<br>';
	break;
	case 4:
		$mixitemopt ='<br>Additional damage +200<br>Attack success rate increase +10<br>';
	break;
	case 5:
		$mixitemopt ='<br>Additional damage +200<br>Attack success rate increase +10<br>';
	break;
	case 7:
		$mixitemopt ='<br>SD recovery rate increase +20<br>Defence success rate increase +10<br>';
	break;	
	case 8:
		$mixitemopt ='<br>SD auto recovery<br>Defence success rate increase +10<br>';
	break;	
	case 9:
		$mixitemopt ='<br>Defensive skill +200<br>Defence success rate increase +10<br>';
	break;	
	case 10:
		$mixitemopt='<br>Max. HP increase +200<br>Defence success rate increase +10<br>';
	break;	
	case 11:
		$mixitemopt ='<br>Max. SD increase +700<br>Defence success rate increase +10<br>';
	break;	
	}	

if($mix>=128) { $mix-=128; $mixed = '<br>'.$mixitemopt; }
else { $mixed=' '; }

if($itemtype>=0 && $itemtype <5)
{
if($mix==1) { $harmony='<br>Min Attack Power Increase<br>'; }
if($mix==2) { $harmony='<br>Max Attack Power Decrease<br>'; }
if($mix==3) { $harmony='<br>Need Strength Decrease<br>'; }
if($mix==4) { $harmony='<br>Need Agility Decrease<br>'; }
if($mix==5) { $harmony='<br>Attack (Min,Max) Increase<br>'; }
if($mix==6) { $harmony='<br>Critical Damage Increase<br>'; }
if($mix==7) { $harmony='<br>Skill Power Increase<br>'; }
if($mix==8) { $harmony='<br>Attack Rate Increase<br>'; }
if($mix==9) { $harmony='<br>SD Rate Increase<br>'; }
if($mix==10) { $harmony='<br>SD Ignore Rate Increase<br>'; }
}
if($itemtype==5) 
{
if($mix==1) { $harmony='<br>Macig Power Increase<br>'; }
if($mix==2) { $harmony='<br>Need Strength Decrease<br>'; }
if($mix==3) { $harmony='<br>Need Agility Decrease<br>'; }
if($mix==4) { $harmony='<br>Skill Power Increase<br>'; }
if($mix==5) { $harmony='<br>Critical Damage Increase<br>'; }
if($mix==6) { $harmony='<br>SD Rate Increase<br>'; }
if($mix==7) { $harmony='<br>Attack Rate Increase<br>'; }
if($mix==8) { $harmony='<br>SD Ignore Rate Increase<br>'; }
}
if($itemtype>5)
{
if($mix==1) { $harmony='<br>Def Power Increase<br>'; }
if($mix==2) { $harmony='<br>Max AG Increase<br>'; }
if($mix==3) { $harmony='<br>Max HP Increase<br>'; }
if($mix==4) { $harmony='<br>HP Auto Rate Increase<br>'; }
if($mix==5) { $harmony='<br>MP Auto Rate Increase<br>'; }
if($mix==6) { $harmony='<br>Def Success Rate Increase<br>'; }
if($mix==7) { $harmony='<br>Damage Rate Increase<br>'; }
if($mix==8) { $harmony='<br>SD Rate Increase<br>'; }
}	
if($mix==0) { $harmony =' '; }
		
	$itemexl = "";
	switch ($iopxltype) {
	case 0 :
		$op1	= 'Incrementa Mana +8';
		$op2	= 'Incrementa Dmg +8';
		$op3	= 'Incrementa Vel. Ataque Magico +7';
		$op4	= 'Dmg Magico +2%';
		$op5	= 'Incrementa Dmg +Level/20';
		$op6	= 'Golpe Excelente +10%';
		$inf	= 'Dmg Adicional';
		break;
	case 1:
		$op1	= 'Incrementa Drop de Zen +40%';
		$op2	= 'Incrementa Exito de Defensa +10%';
		$op3	= 'Refleja Dmg +5%';
		$op4	= 'Incrementa Dmg +4%';
		$op5	= 'Incrementa MaxMana +4%';
		$op6	= 'Incrementa MaxHP +4%';
		$inf	= 'Defensa Adicional';
		$skill	= '';
		break;
	case 2: 
		$op1	= ' Incrementa +'.(50+($itemlevel*5)).' HP';
		$op2	= ' Incrementa +'.(50+($itemlevel*5)).' MP';
		$op3	= ' +Ignora Defensa';
		$op4	= ' +Incrementa Stamina';
		$op5	= ' +Incrementa Velocidad';
		$op6	= '';
		$inf	= 'Dmg Adicional';
		$skill	= '';
		$nocolor= true;
	case 4: // v0.9
		$op1	= ' +'.(50+($itemlevel*5)).' HP';
		$op2	= ' +'.(50+($itemlevel*5)).' MP';
		$op3	= ' Ignora Defensa del Enemigo 3%';
		$op4	= ' +50 Max Stamina';
		$op5	= ' Vel. Ataque Magico +7';
		$op6	= '';
		$inf	= 'Dmg Adicional';
		$skill	= '';
		$nocolor= true;
	}
	if ($iopx1==1) 		$itemexl.='^^'.$op1;
	if ($iopx2==1) 		$itemexl.='^^'.$op2;
	if ($iopx3==1) 		$itemexl.='^^'.$op3;
	if ($iopx4==1) 		$itemexl.='^^'.$op4;
	if ($iopx5==1) 		$itemexl.='^^'.$op5;
	if ($iopx6==1) 		$itemexl.='^^'.$op6;

	if ($fresult['optionType']==1) {
		$itemoption= ($iop).'%';
		$inf	= ' Automatic HP Recovery rate ';
	} elseif ($fresult['optionType']==2) {
		$itemoption= $iop*5;
		$inf	= ' Additional Defense rate ';
	}
	else 
		$itemoption	= $iop*4;

	$c		= '#FFFFFF'; // White -> Normal Item
	if (($iop>1) || ($luck!='')) $c = '#8CB0EA';
	if ($itemlevel>6) $c = '#F4CB3F';
	$tipche		= 0;
	if ($itemexl!='') { 	    // Green -> Excellent Item
		$c	= '#2FF387'; 
		$tipche	= 1;
	}
	if ($itemoption==0)
		$itemoption	= '';
	else
		$itemoption 	= $inf." +".$itemoption;

	if ($itemexl!='') 
		$incrall=20;

	if ($fresult['cmd'])
		$fresult['cmd']+=$incrall;

	if ($fresult['str']) 
		$fresult['str']+=($itemlevel*7)+($itemoption*5)+$incrall;

	if ($fresult['agi']) 
		$fresult['agi']+=($itemlevel*4)+$incrall;

	// In case the item is ancient
	if ($ac>0) {
		$itemexl='';
		$c	= '#2347F3';// Blue -> Ancient Item
		if ($itemoption) 
			$itemoption .= "<br>";
		$itemoption.='Ancient: +'.$ac.' Stamina';
		$tipche=2;
	}
	if (@$nocolor) 	$c='#F4CB3F';

	// Fenrir (from v0.4);
	if (($fresult['type']==12) && ($fresult['id']==37))
	{
		$skill	= "Plasma Storm Skill (Mana:50)";
		$c	= "#8CB0EA";
		if ($iopx1==1) {
			$itemname.=" +Destroy";
			$itemoption="Incrementa Dmg 10%<br>Icrementa Velocidad";
		}
		elseif ($iopx2==1) {
			$itemname.=" +Protect";
			$itemoption="Absorbe Dmg 10%<br>Incrementa Velocidad";
		}
		elseif ($iopx3==1) { // v0.9
			$itemname="<font color=#F4CB3F>Golden Fenrir</font>";
			$itemoption="Incrementa Velocidad";
		}
	} 
	else
		if ((@!$nocolor) &&($itemexl!='') && ($itemname)) $itemname = 'Excellent '.$itemname;

if ($nolevel==1) { $ilvl=0; }
else { $ilvl=$itemlevel; }

$image = ws_image($fresult['id'], $fresult['type'], $tipche, $itemlevel);

$allow = false;

$overlib	= '';
//Windows
$itemformat ='<div align=center style=\'padding-left: 6px; padding-right:6px;font-family:arial;font-size: 10px;\'><span style=\'font-weight:bold;font-size: 11px;\'>[Name]</span>[serial] Durability [Mix] [Harmony] [Skill] [Luck] [Excellent]</div>';
if ($itemname) {
if ($ilvl) $plusche = '+'.$ilvl; 
$overlib	= @str_replace('[Name]','<span style=color:'.$c.'>'.$itemname.' '.$plusche.'</span><br><br>', addslashes($itemformat));
if ($allow) $serial='<font style=font-weight:bold;font-size:11px;color:#ff0000>'.$ItemSerial.'';
$overlib	= @str_replace('[serial]', $serial.'</font>', $overlib);
if ((!@$luck) && (!@$itemexl) && (!@$skill)) {}
$overlib	= str_replace('Durability', $itemdur.' Durabilidad', $overlib);
if (@$itemoption)  $option='<br><font color=#9aadd5>'.$itemoption.'</font>';
if (@$mixed) $mix='<font style=font-weight:bold;font-size:11px;color:#ff66ff>'.$mixed.'';
$overlib	= @str_replace('[Mix]', $mix.'</font>', $overlib);			
if (@$harmony) $harmony='<font style=font-weight:bold;font-size:11px;color:#ffff00>'.$harmony.'';
$overlib	= @str_replace('[Harmony]', $harmony.'</font>', $overlib);	
if (@$luck) $luck='<br><font color=#9aadd5>'.$luck.''; $overlib	= @str_replace('[Luck]', $luck.$option.'</font>', $overlib);
if (@$skill) $skill='<br><font color=#9aadd5>'.$skill.'</font>'; $overlib	= @str_replace('[Skill]', $skill, $overlib);
if (@$itemexl) $exl='<font color=#8CB0EA>'.str_replace('^^','<br>', $itemexl);
$overlib	= @str_replace('[Excellent]', $exl,$overlib);
$output = "background-image:url($image);background-position:center;background-repeat:no-repeat;' onmouseover=\"return overlib('$overlib');\" onmouseout=\"return nd();\">"; 
if($type==1) { return $output; }
else { return array($output,$fresult['X'],$fresult['Y']); }
	}
}

function ws_image($theid,$type,$ExclAnci,$lvl=0) {
	switch ($type) {
		case 14:
			$type=12;
			break;
		case 12:
			$type=13;
			break;
		case 13:
			$type=14;
			break;
	}
	switch ($ExclAnci) {
		case 1:	// Excellent item
		$tnpl	= '10';
		break;
		case 2:	// Ancient item
		$tnpl	= '01';
		break;
		default:// Normal Item
		$tnpl	= '00';

	}
	$itype	= $type*16;
	if ($theid>31) { 
		$nxt	="F9"; 
		$theid	+=-32; 
	} 
	else 
		$nxt	= "00";
	if ($itype<128)  {
		$tipaj = "00";
		$theid += $itype;
	} else {
		$tipaj = "80";
		$itype += -128;
		$theid += $itype;
	}
	$itype	+= $theid;
	$itype	= sprintf("%02X",$itype,00);
	$iid 	= sprintf("%02X",$theid,00);

	if (file_exists('items/items/'.$tnpl.$itype.$tipaj.$nxt.'.gif'))
		$output = 'items/items/'.$tnpl.$itype.$tipaj.$nxt.'.gif';
	else 
		$output = 'items/items/00'.$itype.$tipaj.$nxt.'.gif';

	$i	= $lvl+1;	
	while ($i>0) {
		$i+=-1;
		$il=sprintf("%02X", $i, 00);
		if (file_exists('items/items/'.$tnpl.$itype.$tipaj.$nxt.$il.'.gif')){
			$output = 'items/items/'.$tnpl.$itype.$tipaj.$nxt.$il.'.gif';
			$i=0;
		}
			
	}
	return $output;
}

function equipt($char)
{
$test = mssql_connect('127.0.0.1','sa','a53c8512');
mssql_select_db('MuOnline',$test);
$inventory= mssql_fetch_array(mssql_query("SELECT * FROM Character WHERE Name='$char'"));
mssql_query("declare @it varbinary(1920); set @it=(SELECT [Inventory] FROM [Character] WHERE [Name]='$char'); print @it");

$items = substr(substr(mssql_get_last_message(),2),0,384);
if($inventory['Class'] == 48 || $inventory['Class'] == 50) { $invimage = 'items/inventorymg.gif';}
else { $invimage = 'items/inventory.gif';}
$output = "<br /><table width='295' height='270' border='0' cellpadding='7' cellspacing='0' bordercolor='#FFFFFF' background='$invimage' align='center'>
<tr>
<td height='5' colspan='7'></td>
</tr>
<tr>";
//Imp
{
$output .= "<td width='6' rowspan='5'>&nbsp;</td>";
$item = substr($items,8*32,32);
if(!iteminfo($item)) { $output .= "<td width='51' height='70'></td>";}
else { $output .= "<td width='51' height='70' style='".iteminfo($item)."</td>"; }
$output .= "<td width='22'>&nbsp;</td>";
}
//Helm 
{
$item = substr($items,2*32,32);
if(!iteminfo($item)) { $output .= "<td style=''></td>"; }
else { $output .= "<td style='".iteminfo($item)."</td>"; }
}
//Wings
{
$item = substr($items,7*32,32);
if(!iteminfo($item)) { $output .= "<td colspan='2' style=''></td>"; }
else { $output .= "<td colspan='2' style='".iteminfo($item)."</td>"; }
$output .= "<td width='7' rowspan='5'>&nbsp;</td></tr>";
}
//Left Hand
{
$output .= "<tr>";
$item = substr($items,0*32,32);
if(!iteminfo($item)) { $output .= "<td rowspan='2' style=''></td>"; }
else { $output .= "<td rowspan='2' style='".iteminfo($item)."</td>"; }
}
//Pendant
{
$item = substr($items,9*32,32);
if(!iteminfo($item)) { $output .= "<td height='35' style=''></td>"; }
else { $output .= "<td height='35' style='".iteminfo($item)."</td>"; }
}
//Armor
{
$item = substr($items,3*32,32);
if(!iteminfo($item)) { $output .= "<td rowspan='2' style=''></td>"; }
else { $output .= "<td rowspan='2' style='".iteminfo($item)."</td>"; }
$output .= "<td rowspan='2'>&nbsp;</td>";
}
//Shield
{
$item = substr($items,1*32,32);
if(!iteminfo($item)) { $output .= "<td rowspan='2' style=''></td>"; }
else { $output .= "<td rowspan='2' style='".iteminfo($item)."</td>"; }
$output .= "</tr><tr><td height='70'>&nbsp;</td></tr><tr>";
}
//Gloves
{
$item = substr($items,5*32,32);
if(!iteminfo($item)) { $output .= "<td rowspan='2' style=''></td>"; }
else { $output .= "<td rowspan='2' style='".iteminfo($item)."</td>"; }
}
//Left Ring
{
$item = substr($items,10*32,32);
if(!iteminfo($item)) { $output .= "<td style='height: 30px;'></td>"; }
else { $output .= "<td style='height: 30px;".iteminfo($item)."</td>"; }
}
//Pants
{
$item = substr($items,4*32,32);
if(!iteminfo($item)) { $output .= "<td rowspan='2' style=''></td>"; }
else { $output .= "<td rowspan='2' style='".iteminfo($item)."</td>"; }
}
//Right Ring
{
$item = substr($items,11*32,32);
if(!iteminfo($item)) { $output .= "<td style='height: 30px;'></td>"; }
else { $output .= "<td style='height: 30px;".iteminfo($item)."</td>"; }
}
//Boots
{
$item = substr($items,6*32,32);
if(!iteminfo($item)) { $output .= "<td width='51' rowspan='2' style=''></td>"; }
else { $output .= "<td width='51' rowspan='2' style='".iteminfo($item)."</td>"; }
}
$output .= "</tr>
<tr>
<td height='25'></td>
<td width='20'></td>
</tr>
<tr><td colspan='7' height='7'></td></tr>
</table>";

return $output;

mssql_close();
}
?>