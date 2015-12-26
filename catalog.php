<html>
<head>
<title>ООО Компания "Нитэк"</title>
<meta name="author" content="Rodionov Andrey">
<meta name="copyright" content="">
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
<meta http-equiv="Content-Type" content="text/html; charset=koi8-r">
<link rel="stylesheet" type="text/css" href="itek.css">
</head>
<body bgcolor="#e9ecef" leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">
    <center>
    <table cellpadding="0" cellspacing="0" border="0" width="800" bgcolor="#f5f5f5">
	<tr>
	    <td rowspan="6" background="img/left_sha.gif" width="12">
	    	<img src="img/spacer00.gif" width="12" height="1">
	    </td>
	    <td align="left" height="180" width="130" valign="top" rowspan=2>
		<img src="img/tit2.png" border="0" height="180" width="130">
	    </td>
	    
	    <td align="left" height="130" width="130" valign="top">
		<img src="img/tit4.png" border="0" height="130" width="130">
	    </td>
	    
	    <td align="center" height="130" width="286" background="img/tit5.png"  valign="middle">
		<img src="img/tit3.png" border="0" height="86" width="202">
	    </td>
	    
	    <td align="left" width = "130" valign = "bottom">
		<img src="img/tit6.png" border="0" height="130" width="130">
	    </td>
	    
	    <td align="left" width = "130" height = "180"  rowspan=2 valign=top>
		<img src="img/tit7.png" border="0" height="180" width="130">
	    </td>
	    <td rowspan="6" background="img/right_sh.gif" width="12">
	    	<img src="img/spacer00.gif" width="12" height="1">
	    </td>
	</tr>
	<tr>
	    <td align="center" height="50" valign="bottom" colspan="3">
		<table cellpadding="0" cellspacing="0" border="0" bgcolor="#f5f5f5">
		<tr>
		<td align="left" valign="top" colspan=2 width=90 height="25">
		    <a href="index.html">
   			<img src="img/main.jpg" border="0" height="25" width="90">
		    </a>
		</td>
		<td align="left" valign="top" colspan=2 width=90 height="25"> 
		    <a href="price.zip">
			<img src="img/price.jpg" border="0" height="25" width="90">
		    </a>
		</td>
		<td align="left" valign="top" colspan=2 width=90 height="25">
		    <a href="kontakt.html">
			<img src="img/kontakt.jpg" border="0" height="25" width="90">
		    </a>
		</td>
		<td align="left" valign="top" width=45 colspan=1 height="25">
		  &nbsp;
		</td>
		</tr>
		<tr>
		<td align="left" valign="top" width=45 height="25">
		    &nbsp;
		</td>
		<td align="left" valign="top" colspan=2 width=90 height="25">
		    <a href="catalog.php?rid=1">
			<img src="img/stelaj.jpg" border="0" height="25" width="90"> 
		    </a>
		</td>
		<td align="left" valign="top" colspan=2 width=90 height="25">
		    <a href="catalog.php?rid=2">
			<img src="img/vitrin.jpg" border="0" height="25" width="90"> 
		    </a>
		</td>
		<td align="left" valign="top" colspan=2 width=90 height="25">
		    <a href="catalog.php?rid=3">
			<img src="img/shkaf.jpg" border="0" height="25" width="90">
		    </a>		
		</td>
		</tr>
		<tr>
		<td align="left" valign="top" width=45 height=1>
		</td>
		<td align="left" valign="top" width=45 height=1>
		</td>
		<td align="left" valign="top" width=45 height=1>
		</td>
		<td align="left" valign="top" width=45 height=1>
		</td>
		<td align="left" valign="top" width=45 height=1>
		</td>
		<td align="left" valign="top" width=45 height=1>
		</td>
		<td align="left" valign="top" width=45 height=1>
		</td>
		</tr>
		</table>
	    </td>
	</tr>
	    <td colspan="5">
		<img src="img/line.jpg" border="0" height="50" width="800">
	    </td>
	</tr>
	<tr>
	    <td height = "500" colspan="5" valign="top">
	    <table cellpadding="0" cellspacing="25" width="800">
	    <tr>
		<td align="left" height="180" width="130" valign="top">
	    
	    <?php
		require './lib/func.php';
		$db = db_connect();

		reg_var("zakaz");
		reg_var("filt");
		$filt[0] = "";

		if (isset($submit) &&($submit=="Добавить"))
		{
		    $zz = $zakaz;
		    $zakaz = to_zakaz($zak,$dzak,$zz);
		    
		    show_table($page,$rid,$zakaz,$filt);
		}
		if (isset($submit) &&($submit=="Пересчитать"))
		{
		    $zz = $zakaz;
		    $zakaz = to_zakaz($zak,$dzak,$zz);
#		    show_zakaz($zakaz,1);
		    show_zakaz($zakaz,$page,$youname,$youmail,$youtel,$youmsg);
		}
		if ($submit=="Корзина")
		{
#		    show_zakaz($zakaz,1);
		    show_zakaz($zakaz,$page,$youname,$youmail,$youtel,$youmsg);
		}
		if (isset($submit) &&($submit=="Отправить"))
		{
		    
		    if ($youname!="")
		    {
			if ($youmail!="")
			{
			    echo "<br><br><br><br><br><br><br><br><br>
			    <center><h2>Ваш заказ поставлен в очередь.<br> В ближайшее время с Вами свяжется наш менеджер.</h2></center>";
			    mail_zakaz($youmail,$youname,print_zakaz($zakaz),$youmsg,$youtel);
			    $zz = $zakaz;
			    $zakaz = clean_zakaz($zz);
			}
			else 
			{
			    echo "Вы не ввели Ваш обратный адрес<br>&nbsp;";
#			    show_zakaz($zakaz,1);
			    show_zakaz($zakaz,$page,$youname,$youmail,$youtel,$youmsg);
			}
		    }
		    else
		    {
			    echo "Вы не ввели Ваше имя<br>&nbsp;";
#			    show_zakaz($zakaz,1);
			    show_zakaz($zakaz,$page,$youname,$youmail,$youtel,$youmsg);
		    }
		}
		if (!isset($submit))
		{
		    show_table($page,$rid,$zakaz,$filt);
		}	
		if (isset($submit) &&($submit==" OK "))
		{
		    $ff = $filt ;
		    $filt = to_filter($mfilt,$vfilt,$ff);
		    show_table($page,$rid,$zakaz,$filt);
		}
		if (isset($submit)&&($submit==" Очистить "))
		{
		    $filt = clean_filter($filt);
		    show_table($page,$rid,$zakaz,$filt);
		}
    
?>
		</td>
	    </tr>
	    </table>
	    
	    
	    </td>
	</tr>
	<tr>
	    <td colspan="5">
		<img src="img/line2.jpg" border="0" height="50" width="800">
	    </td>
	</tr>
	<tr>
	    <td height = "15" colspan="5">
	    &nbsp;
	    </td>
	</tr>
    </table>
    </center>
</body>
</html>