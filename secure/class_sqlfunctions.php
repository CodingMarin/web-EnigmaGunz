<?php
class sqlfunctions
{
/************************************
* Some things you need to define:   *
************************************/
  var $coinstable   = "Account";
  var $coinscolumn  = "Coins";
  var $ecoinstable   = "Account";
  var $ecoinscolumn  = "eCoins";
  var $pcoinstable   = "Account";
  var $pcoinscolumn  = "pCoins";
  var $accounttable = "Account";
  var $chartable    = "Character";
  var $clantable    = "Clan";
  var $logintable   = "Login";

  // This will check if it returned more than one row.
  public function checkrow($query)
  {
    $query = mssql_query($query);
    if(mssql_num_rows($query) > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  // This will check if it returned ONE row.
  public function checkrow1($query)
  {
    $query = mssql_query($query);
    if(mssql_num_rows($query) == 1)
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  // This will check if it returned ZERO rows.
  public function checkrow0($query)
  {
    $query = mssql_query($query);
    if(mssql_num_rows($query) == 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }

/*********************************************************************
* Login, register, check and functions to get a certain value.       *
*********************************************************************/
  public function login($accname, $password)
  {
    $accname = clean_alert($accname);
    $password = clean_alert($password);

    if($accname != "" && $password != "")
    {
      if(sqlfunctions::checkrow1("SELECT * FROM Login WHERE UserID = '".$accname."' AND Password = '".$password."'") == true)
      {
        $_SESSION['userid'] = $accname;
        $_SESSION['ip']     = $_SERVER['REMOTE_ADDR'];
        return 2;
      }
      else
      {
        echo '<meta HTTP-EQUIV="REFRESH" content="0; url=index.php">';
        return 1;
      }
    }
    else
    {
      echo '<meta HTTP-EQUIV="REFRESH" content="0; url=index.php">';
      return 0;
    }
  }


  public function checkban($accname)
  {
    $accname = clean_alert($accname);

    if(sqlfunctions::checkrow1("SELECT UGradeID FROM ".$this->accounttable." WHERE UserID = '".$accname."'") == true)
    {
      $ugradeid = sqlfunctions::getaccdata("UGradeID", "".$accname."");
      if($ugradeid == 253)
      {
        return true;
      }
      else
      {
        return false;
      }
    }
    else
    {
      setmsg("This account does not exist!");
      return false;
    }
  }

   // This function can be used to check if a character belongs to the SESSION account name.
  // $charname = character name, $accname = SESSION account name.
  public function checkcharowner($charname, $accname)
  {
    $charname = clean_alert($charname);
    $accname  = clean_alert($accname);

    if($charname != "" && $accname != "")
    {
        if(sqlfunctions::checkrow1("SELECT AID FROM ".$this->chartable." WHERE Name = '".$charname."' AND DeleteFlag = 0") == true)
        {
          $aid1  = sqlfunctions::getchardata("AID", "".$charname."");
          $query = mssql_query("SELECT AID FROM ".$this->accounttable." WHERE UserID = '".$accname."'");
          $aid2  = sqlfunctions::getaccdata("AID", "".$accname."");

          if($aid1 == $aid2)
          {
            return true;
          }
          else
          {
            return false;
          }
        }
        else
        {
          setmsg("Character does not exist!");
          return false;
        }
    }
    else
    {
      setmsg("Fields are empty!");
      return false;
    }
  }

  public function checkcharownercid($cid, $accname)
  {
    $cid = clean_alert($cid);
    $accname  = clean_alert($accname);

    if($cid != "" && $accname != "" && ctype_digit($cid))
    {
        if(sqlfunctions::checkrow1("SELECT AID FROM ".$this->chartable." WHERE CID = '".$cid."' AND DeleteFlag = 0") == true)
        {
          $query = mssql_query("SELECT Name FROM Character WHERE CID = '".$cid."'");
          $charname = mssql_result($query, 0, 'Name');
          $aid1  = sqlfunctions::getchardata("AID", "".$charname."");
          $query = mssql_query("SELECT AID FROM ".$this->accounttable." WHERE UserID = '".$accname."'");
          $aid2  = sqlfunctions::getaccdata("AID", "".$accname."");

          if($aid1 == $aid2)
          {
            return true;
          }
          else
          {
            return false;
          }
        }
        else
        {
          setmsg("Character does not exist!");
          return false;
        }
    }
    else
    {
      setmsg("Fields are empty!");
      return false;
    }
  }

  // This function can be used to check if a character is the owner of a clan.
  public function checkclanowner($charname, $clanname)
  {
    $charname = clean_alert($charname);
    $clanname = clean_alert($clanname);

    if($charname != "" && $clanname != "")
    {
      if(sqlfunctions::checkrow1("SELECT CID FROM ".$this->chartable." WHERE Name = '".$charname."' AND DeleteFlag = 0") == true)
      {
        $cid = sqlfunctions::getchardata("CID", "".$charname."");
        if(sqlfunctions::checkrow1("SELECT MasterCID FROM ".$this->clantable." WHERE Name = '".$clanname."' AND DeleteFlag = 0") == true)
        {
          $mastercid = sqlfunctions::getclandata("MasterCID", "".$clanname."");
          if($mastercid == $cid)
          {
            return true;
          }
          else
          {
            return false;
          }
        }
        else
        {
          return false;
        }
      }
      else
      {
        setmsg("Character does not exist!");
        return false;
      }
    }
    else
    {
      setmsg("Fields are empty!");
      return false;
    }
  }

  // Function to check if a character has a clan.
  public function charhasclan($charname)
  {
    $charname = clean_alert($charname);

    if($charname != "")
    {
      if(sqlfunctions::checkrow1("SELECT CID FROM ".$this->chartable." WHERE Name = '".$charname."' AND DeleteFlag = 0") == true)
      {
        $cid = sqlfunctions::getchardata("CID", "".$charname."");
        if(sqlfunctions::checkrow1("SELECT Name FROM ".$this->clantable." WHERE MasterCID = '".$cid."' AND DeleteFlag = 0") == true)
        {
          return true;
        }
        else
        {
          return false;
        }
      }
      else
      {
        setmsg("Character does not exist!");
        return false;
      }
    }
    else
    {
      setmsg("Field is empty!");
      return false;
    }
  }

  public function charexists($charname)
  {
    $charname = clean_alert($charname);

    if($charname != "")
    {
      if(sqlfunctions::checkrow1("SELECT * FROM ".$this->chartable." WHERE Name = '".$charname."' AND DeleteFlag = 0") == true)
      {
        return true;
      }
      else
      {
        return false;
      }
    }
    else
    {
      setmsg("Field is empty!");
      return false;
    }
  }

  public function getaccdata($column, $name)
  {
    $column = clean_alert($column);
    $name   = clean_alert($name);

    $query = "SELECT ".$column." FROM ".$this->accounttable." WHERE UserID = '".$name."'";
    if(sqlfunctions::checkrow1($query) == true)
    {
      $query = mssql_query("SELECT ".$column." FROM ".$this->accounttable." WHERE UserID = '".$name."'");
      return mssql_result($query, 0, ''.$column.'');
    }
    else
    {
      setmsg("This account does not exist!");
      return false;
    }
  }

  public function getchardata($column, $name)
  {
    $column = clean_alert($column);
    $name   = clean_alert($name);

    $query = "SELECT ".$column." FROM ".$this->chartable." WHERE Name = '".$name."'";
    if(sqlfunctions::checkrow1($query) == true)
    {
      $query = mssql_query("SELECT ".$column." FROM ".$this->chartable." WHERE Name = '".$name."'");
      return mssql_result($query, 0, ''.$column.'');
    }
    else
    {
      setmsg("This account does not exist!");
      return false;
    }
  }

  public function getclandata($column, $name)
  {
    $column = clean_alert($column);
    $name   = clean_alert($name);

    $query = "SELECT ".$column." FROM ".$this->clantable." WHERE Name = '".$name."'";
    if(sqlfunctions::checkrow1($query) == true)
    {
      $query = mssql_query("SELECT ".$column." FROM ".$this->clantable." WHERE Name = '".$name."'");
      return mssql_result($query, 0, ''.$column.'');
    }
    else
    {
      setmsg("This account does not exist!");
      return false;
    }
  }

  public function getlogindata($column, $name)
  {
    $column = clean_alert($column);
    $name   = clean_alert($name);

    $query = "SELECT ".$column." FROM ".$this->logintable." WHERE UserID = '".$name."'";
    if(sqlfunctions::checkrow1($query) == true)
    {
      $query = mssql_query("SELECT ".$column." FROM ".$this->logintable." WHERE UserID = '".$name."'");
      return mssql_result($query, 0, ''.$column.'');
    }
    else
    {
      setmsg("This account does not exist!");
      return false;
    }
  }

  public function getcoins($accname)
  {
    $accname = clean_alert($accname);

    if($accname != "")
    {
      if(sqlfunctions::checkrow1("SELECT ".$this->coinscolumn." FROM ".$this->coinstable." WHERE UserID = '".$accname."'") == true)
      {
        $query = mssql_query("SELECT ".$this->coinscolumn." FROM ".$this->coinstable." WHERE UserID = '".$accname."'");
        return mssql_result($query, 0, $this->coinscolumn);
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false;
    }
  }

  public function removecoins($accname, $coins)
  {
    $accname = clean_alert($accname);

    if($accname != "")
    {
      if(sqlfunctions::checkrow1("SELECT Coins FROM Account WHERE UserID = '".$accname."'") == true)
      {
        mssql_query("UPDATE Account SET Coins = Coins - '".$coins."' WHERE UserID = '".$accname."'");
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false;
    }
  }
  
  
  
  
    public function getecoins($accname)
  {
    $accname = clean_alert($accname);

    if($accname != "")
    {
      if(sqlfunctions::checkrow1("SELECT ".$this->ecoinscolumn." FROM ".$this->ecoinstable." WHERE UserID = '".$accname."'") == true)
      {
        $query = mssql_query("SELECT ".$this->ecoinscolumn." FROM ".$this->ecoinstable." WHERE UserID = '".$accname."'");
        return mssql_result($query, 0, $this->ecoinscolumn);
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false;
    }
  }

  public function removeecoins($accname, $coins)
  {
    $accname = clean_alert($accname);

    if($accname != "")
    {
      if(sqlfunctions::checkrow1("SELECT eCoins FROM Account WHERE UserID = '".$accname."'") == true)
      {
        mssql_query("UPDATE Account SET eCoins = eCoins - '".$coins."' WHERE UserID = '".$accname."'");
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false;
    }
  }
  
      public function getpcoins($accname)
  {
    $accname = clean_alert($accname);

    if($accname != "")
    {
      if(sqlfunctions::checkrow1("SELECT ".$this->pcoinscolumn." FROM ".$this->pcoinstable." WHERE UserID = '".$accname."'") == true)
      {
        $query = mssql_query("SELECT ".$this->pcoinscolumn." FROM ".$this->pcoinstable." WHERE UserID = '".$accname."'");
        return mssql_result($query, 0, $this->pcoinscolumn);
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false;
    }
  }

  public function removepcoins($accname, $coins)
  {
    $accname = clean_alert($accname);

    if($accname != "")
    {
      if(sqlfunctions::checkrow1("SELECT pCoins FROM Account WHERE UserID = '".$accname."'") == true)
      {
        mssql_query("UPDATE Account SET pCoins = pCoins - '".$coins."' WHERE UserID = '".$accname."'");
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false;
    }
  }

/******************************************************
* Other functions to insert things into the database. *
******************************************************/

  public function additem($charname, $itemid)
  {
    $charname = clean_alert($charname);
    $itemid   = clean_alert($itemid);

    if($charname != "" && $itemid != "" && ctype_digit($itemid))
    {
      if(sqlfunctions::checkrow1("SELECT CID FROM ".$this->chartable." WHERE Name = '".$charname."' AND DeleteFlag = 0") == true)
      {
        $cid   = sqlfunctions::getchardata("CID", "".$charname."");
        $query = mssql_query("INSERT INTO CharacterItem (CID, ItemID, RegDate) VALUES ('".$cid."', '".$itemid."', GETDATE())");
        return true;
      }
      else
      {
        setmsg("Character does not exist!");
        return false;
      }
    }
    else
    {
      setmsg("Fields are empty or/and the ItemID is not numeric!");
      return false;
    }
  }

  public function buyitem($charname, $itemid, $costs)
  {
    $charname = clean_alert($charname);
    $itemid   = clean_alert($itemid);
    $costs    = clean_alert($costs);

    if($charname != "" && $itemid != "" && $costs != "" && ctype_digit($costs) && ctype_digit($itemid))
    {
      if(sqlfunctions::checkrow1("SELECT CID FROM ".$this->chartable." WHERE Name = '".$charname."'") == true)
      {
        $aid    = sqlfunctions::getchardata("AID", "".$charname."");
        $query  = mssql_query("SELECT UserID FROM ".$this->accounttable." WHERE AID = '".$aid."'");
        $accname = mssql_result($query, 0, 'UserID');
        $coins = sqlfunctions::getaccdata("".$this->coinscolumn."", $userid);

        if($coins >= $costs)
        {
          $query = mssql_query("UPDATE ".$this->coinstable." SET ".$this->coinscolumn." = ".$this->coinscolumn." - ".$costs." WHERE UserID = '".$accname."'");
          sqlfunctions::additem("".$charname."", "".$itemid."");
          return true;
        }
        else
        {
          setmsg("You don't got enough coins!");
          return false;
        }
      }
      else
      {
        setmsg("This character does not exist!");
        return false;
      }
    }
    else
    {
      setmsg("Fields are empty or/and the ItemId is not numeric!");
      return false;
    } 

  }
  public function topchars()
  {
 $i = 1;	
    $query = mssql_query("SELECT TOP 5 Name, Level, Killcount, Deathcount FROM ".$this->chartable." WHERE DeleteFlag = 0 ORDER BY XP/PlayTime DESC");
    while($row = mssql_fetch_row($query))
    {
	  
      echo '<div id="rankingbg"><tr><td>'.$i++.'</td>&nbsp;&nbsp;<td><a href="?page=charinfo&name='.$row[0].'"><font color="black">'.convertcolor($row[0]).'</font></a></td>&nbsp;&nbsp;<td>'.$row[1].'</td>&nbsp;&nbsp;<td>'.$row[2]/$row[3].'%</td></tr><br></div>';

    }

 }
  public function topclans()
  {
 $i = 1;	
    $query = mssql_query("SELECT TOP 5 Name, Point FROM ".$this->clantable." WHERE DeleteFlag = 0 ORDER BY Point DESC");
    while($row = mssql_fetch_row($query))
    {
      echo '<div id="rankingbg"><tr><td>'.$i++.'</td>&nbsp;&nbsp;<td><a href="?page=claninfo&name='.$row[0].'"><font color="black">'.convertcolor($row[0]).'</font></a></td>&nbsp;&nbsp;<td>'.$row[1].'</td></tr><br></div>';
    }
  }

  public function getplayers()
  {
    $query = mssql_query("SELECT CurrPlayer FROM ServerStatus WHERE Opened = 1");
    echo mssql_result($query, 0, 'CurrPlayer');
  }

  public function getaccgrade($userid)
  {
    $userid = clean_alert($userid);
    $query  = mssql_query("SELECT UGradeID FROM ".$this->accounttable." WHERE UserID = '".$userid."'");
    if(mssql_num_rows($query) == 1)
    {
      $ugradeid = mssql_result($query, 0, 'UGradeID');
      if($ugradeid == 255)
      {
        echo "<font color='#FF0000'>Administrador</font>";
      }
      elseif($ugradeid == 252 || $ugradeid == 254)
      {
        echo "<font color='#00E600'>Game Master</font>";
      }
      elseif($ugradeid == 253)
      {
        echo "<font color='#000'>Baneado</font>";
      }
      elseif($ugradeid == 104)
      {
        echo "<font color='#CCC'>Muted</font>";
      }
      elseif($ugradeid == 2)
      {
        echo "<font color='#FFCC00'>Event Winner</font>";
      }
	elseif($ugradeid == 3)
      {
        echo "<font color='#003DBB'>Donator</font>";
      }
	elseif($ugradeid == 4)
      {
        echo "<font color='#FFCC00'>Donator</font>";
      }
	elseif($ugradeid == 5)
      {
        echo "<font color='#E77A18'>Donator</font>";
      }
	elseif($ugradeid == 6)
      {
        echo "<font color='#9933CC'>Donator</font>";
      }
	elseif($ugradeid == 7)
      {
        echo "<font color='#00FF66'>Donator</font>";
      }
	elseif($ugradeid == 8)
      {
        echo "<font color='#FF00FF'>Donator</font>";
      }
	elseif($ugradeid == 9)
      {
        echo "<font color='#57DEFB'>Donator</font>";
      }
      else
      {
        echo "<font color='#FFF'>Usuario Normal</font>";
      }
    }
  }

  public function getchars($userid)
  {
    $userid = clean_alert($userid);
    $aid    = $this->getaccdata("AID", $userid);
    $query  = mssql_query("SELECT Name, Level, XP, KillCount, DeathCount FROM ".$this->chartable." WHERE AID = '".$aid."' AND DeleteFlag = 0");
    while($row = mssql_fetch_row($query))
    {
      echo '<tr><td><a href="?page=charinfo&name='.$row[0].'">'.convertcolor($row[0]).'</a></td><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td><td>'.$row[4].'</td><td>'.$row[5].'</td></tr>';
    }
  }

  public function getcharscid($userid)
  {
    $userid = clean_alert($userid);
    $aid    = $this->getaccdata("AID", $userid);
    $query  = mssql_query("SELECT Name, CID FROM ".$this->chartable." WHERE AID = '".$aid."' AND DeleteFlag = 0");
    while($row = mssql_fetch_row($query))
    {
      echo '<option value="'.$row[1].'">'.$row[0].'</option>';
    }
  }

  public function getclans($userid)
  {
    $userid = clean_alert($userid);
    $aid    = $this->getaccdata("AID", $userid);
    $query  = mssql_query("SELECT Clan.Name, Clan.Point, Clan.Wins, Clan.Losses, Clan.Draws, Character.Name AS Leader FROM Clan INNER JOIN Character ON Clan.MasterCID = Character.CID WHERE (Clan.DeleteFlag = 0) AND (Character.DeleteFlag = 0) AND (Character.AID = '".$aid."')");

    while($row = mssql_fetch_row($query))
    {
      echo '<tr><td><a href="?page=claninfo&name='.$row[0].'">'.$row[0].'</a></td><td><a href="?page=charinfo&name='.$row[5].'">'.convertcolor($row[5]).'</a></td><td>'.$row[1].'<td>'.$row[2].'</td><td>'.$row[3].'</td><td>'.$row[4].'</td></tr>';
    }
  }

  public function getclans2($userid)
  {
    $userid = clean_alert($userid);
    $aid    = $this->getaccdata("AID", $userid);
    $query  = mssql_query("SELECT Clan.Name FROM Clan INNER JOIN Character ON Clan.MasterCID = Character.CID WHERE (Clan.DeleteFlag = 0) AND (Character.DeleteFlag = 0) AND (Character.AID = '".$aid."')");

    while($row = mssql_fetch_row($query))
    {
      echo '<option value='.$row[0].'>'.$row[0].'</option>';
    }
  }

  public function getclansname($userid)
  {
    $userid = clean_alert($userid);
    $aid    = $this->getaccdata("AID", $userid);
    $query  = mssql_query("SELECT Clan.Name, Clan.CLID FROM Clan INNER JOIN Character ON Clan.MasterCID = Character.CID WHERE (Clan.DeleteFlag = 0) AND (Character.DeleteFlag = 0) AND (Character.AID = '".$aid."')");

    while($row = mssql_fetch_row($query))
    {
      echo '<a href="?page=manageclan&clid='.$row[1].'">'.$row[0].'</a><br />';
    }
  }

  public function getclanchars($clid)
  {
    $clid = clean_alert($clid);
    $query = mssql_query("SELECT Character.Name, Character. LEVEL, ClanMember.Grade, ClanMember.CID FROM Character INNER JOIN ClanMember ON Character.CID = ClanMember.CID WHERE (ClanMember.CLID = '".$clid."') AND (Character.DeleteFlag = 0) ORDER BY ClanMember.Grade ASC");

    while($row = mssql_fetch_row($query))
    {
      echo '<tr><td class="clanchar"><a href="?page=charinfo&name='.$row[0].'">'.convertcolor($row[0]).'</a></td><td class="clanchar">'.$row[1].'</td><td class="clanchar">'.$this->convertclangrade($row[2]).'</td><td class="clanchar"><form action="" method="post"><input type="hidden" name="cid" value="'.$row[3].'"><input type="submit" value="Kick" name="kickmember" class="kickbutton" title="Kick '.$row[0].' out of the clan." /></form></td></tr>';
    }
  }

  public function convertclangrade($grade)
  {
    if($grade == 1)
    {
      return "Lider";
    }
    elseif($grade == 2)
    {
      return "Administrator";
    }
    else
    {
      return "Member";
    }
  }

  public function convertgender($gender)
  {
    if($gender == 0)
    {
      return "Hombre";
    }
    elseif($gender == 1)
    {
      return "Mujer";
    }
    elseif($gender == 2)
    {
      return "Both";
    }
    else
    {
      return "Todos";
    }
  }

  public function deleteclanmember($cid, $clid)
  {
    $cid  = clean_alert($cid);
    $clid = clean_alert($clid);

    if($cid != "" && ctype_digit($cid) && ctype_digit($clid))
    {
      if($this->checkrow1("SELECT * FROM Character WHERE CID = '".$cid."' AND DeleteFlag = 0") == true)
      {
        if($this->checkrow1("SELECT * FROM ClanMember WHERE CID = '".$cid."'") == true)
        {
          $query = mssql_query("SELECT CLID, Grade FROM ClanMember WHERE CID = '".$cid."'");
          $clid2 = mssql_result($query, 0, 'CLID');

          if($clid2 == $clid)
          {
            $grade = mssql_result($query, 0, 'Grade');
            if($grade != 1)
            {
              $query = mssql_query("DELETE FROM ClanMember WHERE CID = '".$cid."' AND CLID = '".$clid."'");
              alert("This character has been successfully kicked!");
              redirect("?page=manageclan&clid=".$clid, 0);
            }
            else
            {
              alert("You can't kick yourself, dumbass.");
              redirect("?page=manageclan&clid=".$clid, 0);
            }
          }
          else
          {
            alert("This character does not belong to your clan!");
            redirect("?page=manageclan&clid=".$clid, 0);
          }
        }
        else
        {
          alert("This character does not have a clan!");
          redirect("?page=manageclan&clid=".$clid, 0);
        }
      }
      else
      {
        alert("This character does not exist!");
        redirect("?page=manageclan&clid=".$clid, 0);
      }
    }
    else
    {
      alert("CID is empty or not a number!");
      redirect("?page=manageclan&clid=".$clid, 0);
    }
  }

  public function indranking()
  {
    $query = mssql_query("SELECT TOP 18 Name, Level, XP, KillCount, DeathCount FROM Character WHERE DeleteFlag = 0 ORDER BY XP DESC");
    while($row = mssql_fetch_row($query))
    {
      echo '<tr><td>'.convertcolor($row[0]).'</td><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td><td>'.$row[4].'</td></tr>';
    }
  }

  public function indranking2($name)
  {
    $name = clean($name);
    $query = mssql_query("SELECT TOP 18 Name, Level, XP, KillCount, DeathCount FROM Character WHERE DeleteFlag = 0 AND Name LIKE '%".$name."%' ORDER BY XP DESC");
    while($row = mssql_fetch_row($query))
    {
      echo '<tr><td>'.convertcolor($row[0]).'</td><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td><td>'.$row[4].'</td></tr>';
    }
  }

  public function roundkd($kc, $dc)
  {
    if($kc == 0)
    {
      $kc = 1;
    }

    if($dc == 0)
    {
      $dc = 1;
    }

    return round($kc / $dc, 2);
  }

  public function getclanofchar($char)
  {
    $char = clean($char);
    $query = mssql_query("SELECT CID FROM Character WHERE Name = '".$char."' AND DeleteFlag = 0");

    if(mssql_num_rows($query) == 1)
    {
      $cid   = mssql_result($query, 0, 'CID');
      $query = mssql_query("SELECT Clan.Name, ClanMember.Grade FROM Clan INNER JOIN ClanMember ON Clan.CLID = ClanMember.CLID WHERE (ClanMember.CID = '".$cid."')");

      if(mssql_num_rows($query) == 1)
      {
        $cname = mssql_result($query, 0, 'Name');
        return $cname;
      }
    }
    else
    {
      return "Char does not exist!";
    }
  }

  public function getgradeofchar($char)
  {
    $char = clean($char);
    $query = mssql_query("SELECT CID FROM Character WHERE Name = '".$char."' AND DeleteFlag = 0");

    if(mssql_num_rows($query) == 1)
    {
      $cid   = mssql_result($query, 0, 'CID');
      $query = mssql_query("SELECT Clan.Name, ClanMember.Grade FROM Clan INNER JOIN ClanMember ON Clan.CLID = ClanMember.CLID WHERE (ClanMember.CID = '".$cid."')");

      if(mssql_num_rows($query) == 1)
      {
        $grade = mssql_result($query, 0, 'Grade');
        $grade = $this->convertclangrade($grade);
        return " (" . $grade . ")";
      }
    }
    else
    {
      return "Char does not exist!";
    }
  }

  public function getupdates()
  {
    $query = mssql_query("SELECT TOP(3) ID, Title, message, author, postdate, Type, image FROM News WHERE Active = 1 ORDER BY ID DESC");

    while($row = mssql_fetch_row($query))
    {
	$event = 1;
	$update = 2;
	$new = 3;
	if ($row[5] == $event) {
	      echo '<div class="newsbg">
				<div class="left">
					<div class="icon"><img src="img/News/'.$row[6].'" width="59px" height="59px" style="margin-left:1px; margin-top:1px;"></div>
					<div class="event"></div>
				</div>
				<div class="title"><a href="?page=news&id='.$row[0].'"><b>'.$row[1].'</b></a></div><div class="date">'.$row[4].'</div>
				<div class="news">
				<p>'.$row[2].'</p>
				</div>
			</div>'; } elseif($row[5] == $update) {
	      echo '<div class="newsbg">
				<div class="left">
					<div class="icon"><img src="img/News/'.$row[6].'" width="59px" height="59px" style="margin-left:1px; margin-top:1px;"></div>
					<div class="update"></div>
				</div>
				<div class="title"><a href="?page=news&id='.$row[0].'"><b>'.$row[1].'</b></a></div><div class="date">'.$row[4].'</div>
				<div class="news">
				<p>'.$row[2].'</p>
				</div>
			</div>'; } else {
	      echo '<div class="newsbg">
				<div class="left">
					<div class="icon"><img src="img/News/'.$row[6].'" width="59px" height="59px" style="margin-left:1px; margin-top:1px;"></div>
					<div class="new"></div>
				</div>
				<div class="title"><a href="?page=news&id='.$row[0].'"><b>'.$row[1].'</b></a></div><div class="date">'.$row[4].'</div>
				<div class="news">
				<p>'.$row[2].'</p>
				</div>
			</div>'; }
    }
  }

  public function getevents()
  {
    $query = mssql_query("SELECT TOP(6) ID, Title FROM News WHERE Active = 1 AND Type = 1 ORDER BY ID DESC");

    while($row = mssql_fetch_row($query))
    {
      echo '<li class="updates1"><a href="?page=news&id='.$row[0].'">'.$row[1].'</a></li>';
    }
  }

  public function checkipban($ip)
  {
    $ip = clean($ip);
    if($this->checkrow1("SELECT * FROM Web_IPBans WHERE IP = '".$ip."'") == true)
    {
      redirect("banned.php", 0);
    }
  }
  
    public function anouncement()
  {	
$query = mssql_query("SELECT TOP(1) * FROM Web_anouncements ORDER BY ID DESC");

while($fetch = mssql_fetch_array($query))
{
	echo "".$fetch['anouncement']."";
}
    
  }
/***********************
* Coded By SuperWaffle *
***********************/
}

$sqlf = new sqlfunctions();
?>