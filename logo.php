<?mysql_connect('localhost', 'root', '');
mysql_select_db('pracovni_vykaz');
@$sql = mysql_query("select logo from firma where id='1'");
@$sql1 = mysql_query("select soubor from firma where id='1'");
$foto= mysql_result($sql,0,0);
$typ= mysql_result($sql1,0,0);
Header ("Content-type: $typ");
print $foto;?>
