<?
$bloquiados = array(";","\"","%","'","+","#","$","--","==","z'; U\PDATE Account S\ET ugradeid=char","x'; U\PDATE Character S\ET level=99;-\-","x';U\PDATE Account S\ET ugradeid=255;-\-","x';U\PDATE Account D\ROP ugradeid=255;-\-","x';U\PDATE Account D\ROP "); 
foreach($_POST as $valor)
{
	foreach($bloquiados as $bloquiados2)
	{
		if(substr_count(strtolower($valor), strtolower($bloquiados2)) > 0) 
		{
		  die("<div align=\"center\">
  <p><br>
    <p>&nbsp;</p>
  <p>&nbsp;</p>
    <img src=\"images/noob.gif\" /><br />
    <br />
      <span class=\"textbox style20\">Sql Inject Detect No Podras Inyectar Noobie u.u</span></p>
  <p><br />
    <a href=\"javascript: history.back(-1);\" class=\"style30\">Regresar</a></p>
</div>");
		}
	}
}
foreach($_GET as $valor)
{
	foreach($bloquiados as $bloquiados2)
	{
		if(substr_count(strtolower($valor), strtolower($bloquiados2)) > 0) 
		{
		  die("<div align=\"center\">
  <p><br>
    <p>&nbsp;</p>
  <p>&nbsp;</p>
    <br />
      <span class=\"textbox style20\">Sql Inject Detect No Podras Inyectar </span></p>
  <p><br />
    <a href=\"javascript: history.back(-1);\" class=\"style30\">Regresar</a></p>
</div>");
		}
	}
}
foreach($_COOKIE as $valor)
{
	foreach($bloquiados as $bloquiados2)
	{
		if(substr_count(strtolower($valor), strtolower($bloquiados2)) > 0) 
		{
		  die("<div align=\"center\">
  <p><br>
    <p>&nbsp;</p>
  <p>&nbsp;</p>
    <br />
      <span class=\"textbox style20\">N&atilde;o use Caracteres Especiais! </span></p>
  <p><br />
    <a href=\"javascript: history.back(-1);\" class=\"style30\">Voltar</a></p>
</div>");
		}
	}
} ?>