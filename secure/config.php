<?
@session_start();
//MSSQL Server configuration
$_MSSQL[Host]               = "ALEXYJOSE-PC";
$_MSSQL[User]               = "sa";
$_MSSQL[Pass]               = "25818608";
$_MSSQL[DBNa]               = "GunzDB";
$r = mssql_connect($_MSSQL[Host], $_MSSQL[User], $_MSSQL[Pass]) or die("Cant connect to database");
mssql_select_db($_MSSQL[DBNa], $r);
// Here you set the language for the panel
// If you set this to english, the panel will try to load lang/english.php
$_CONFIG[Language]  = "english";
// Gunz Database Configuration
$_CONFIG[AccountTable]  = "Account";
$_CONFIG[LoginTable]    = "Login";
$_CONFIG[CharTable]     = "Character";
$_CONFIG[CItemTable]    = "CharacterItem";
$_CONFIG[AItemTable]    = "AccountItem";
$_CONFIG[ClanTable]     = "Clan";
$_CONFIG[ClanMembTable] = "ClanMember";
$_CONFIG[ClanLogTable]  = "ClanGameLog";
// Plugins Configuration
// To Disable, set the variable to 0
// To Enable, set the variable to 1
$_CONFIG[CountryBlock]  = 0;        // Add functions to Block / Unblock access to your GunZ Server
//MySQL Server configuration
$_MYSQL[Host]               = "localhost";
$_MYSQL[User]               = "root";
$_MYSQL[Pass]               = "pasword";
$_MYSQL[DBNa]               = "foro";
//Configuration
$_CONFIG[NewsFID]           = 2;
$_CONFIG[EventsFID]         = 0;
$_CONFIG[vBulletinPrefix]   = "xxxxx";
$_CONFIG[ForumURL]          = "http://xxx.tk/";
//Offline page
$_CONFIG[OfflinePage]       = "";
// Gunz Database Configuration
$_CONFIG[LoginTable]    = "Login";
$_CONFIG[CharTable]     = "Character";
$_CONFIG[ClanTable]    = "Clan";
$_CONFIG[ClanmemberTable]    = "ClanMember";
$color[255] = array(255,153,51); // Administrator
$color[254] = array(255,153,51); // Developer/Gamemaster
$color[253] = array(255,255,255); // Banned
$color[252] = array(255,153,51); // Hidden GM
$color[2]   = array(0,68,255); // User With Jjang
$color[0]   = array(255,255,255); // Normal User
// Here you set the language for the panel
// If you set this to english, the panel will try to load lang/english.php
$_CONFIG[Language]  = "english";
// Gunz Database Configuration
$_CONFIG[LoginTable]    = "Login";
$_CONFIG[CharTable]     = "Character";
$_CONFIG[ClanTable]    = "Clan";
$_CONFIG[ClanmemberTable]    = "ClanMember";
?>