<?php

require 'config.php';

function mail_text($mail,$name,$note,$tel)
{
    global $CONF;
    $today = date("D M j G:i:s T Y"); 
    $mail_zakaz ="<html><head>
    <title>ООО 'Итек'</title>
    </head><body>
     <b>От кого:&nbsp;&nbsp;</b>$name<br>
     <b>E-mail:&nbsp;&nbsp;</b>$mail<br>
     <b>Телефон:&nbsp;&nbsp;</b>$tel<br>
     <b>Дата:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>$today<br>
     <b>Сообщение: </b><br> $note <br>
    </body></html>";
    
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=koi8-r\r\n";
    $headers .= "From: $name <$mail>\r\n";
    
    mail ($CONF['mail_itek'], "Web site <www.nitek-ufa.ru> text.", $note, $headers);
}

function mail_zakaz($mail,$name,$pr_zakaz,$note,$tel)
{
    global $CONF;
    $today = date("D M j G:i:s T Y"); 
    $mail_zakaz ="<html><head>
    <title>ООО 'Итек'</title>
    </head><body>
     <b>От кого:&nbsp;&nbsp;</b>$name<br>
     <b>E-mail:&nbsp;&nbsp;</b>$mail<br>
     <b>Телефон:&nbsp;&nbsp;</b>$tel<br>
     <b>Сообщение: </b><br> $note <br>
     <b>Дата:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>$today<br>
     <b>Заказ:&nbsp;&nbsp;&nbsp;&nbsp; </b><br>&nbsp;".
    $pr_zakaz.
    "</body></html>";
    
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=koi8-r\r\n";
    $headers .= "From: $name <$mail>\r\n";
    
    mail ($CONF['mail_itek'], "Web site <www.nitek-ufa.ru> buy.", $mail_zakaz, $headers);
}

function print_zakaz($zakaz)
{
    $pr_zak = "";
    $pr_zak = $pr_zak ."<table cellpadding=0 cellspacing=0 border=0 width=100% bgcolor=#999999 align=center>
	<TD>  
    <TABLE cellSpacing=1 cellPadding=5 border=0 width=100%>
	<TR bgcolor=#EEEEEE>
	    <TD align=middle class=tmain rowspan=2><b>Артикул</b></TD>
	    <TD align=middle class=tmain rowspan=2><b>Кол-во<br>полок</b></TD>
	    <TD align=middle class=tmain colspan=3><b>Размеры, мм</b></TD>
	    <TD align=middle class=tmain rowspan=2><b>Цена,<br>руб.</b></TD>
	    <TD align=middle class=tmain rowspan=2><b>Заказ,<br>шт.</b></TD>
	    <TD align=middle class=tmain rowspan=2><b>Стоимость,<br>руб.</b></TD>
	</TR>
	<TR bgcolor=#EEEEEE>
	    <TD align=middle class=tmain><b>высота</b></TD>
	    <TD align=middle class=tmain><b>ширина</b></TD>
	    <TD align=middle class=tmain><b>глубина</b></TD>
	</TR>";
	$keys = array_keys($zakaz);
	$summ = 0;
	for ($i=0;$i<count($zakaz);$i++) 
	{

    	    $did = $keys[$i];
	    $sql2="select * from itek_data where did=$did";
    	    $res2=mysql_query($sql2);
	    	    
	    $result2=mysql_fetch_array($res2);
	    $name = $result2[name];
    	    $W     = $result2[W];
    	    $L     = $result2[L];
    	    $H     = $result2[H];
    	    $cost    = $result2[cost];
    	    $kol  = $result2[kol];
    	    $did   = $result2[did];
	    $stoim = $cost*$zakaz[$did];
	    $summ = $summ + $stoim;
       
    
    	    if ($W == "")
    	    {
    		$W = "-";
    	    }
    	    if ($L==0)
    	    {
    		$L = "-";
    	    }
    	    if ($H==0)
    	    {
    		$H = "-";
    	    }
    	    if ($cost==0)
    	    {
    		$cost = "-";
    	    }
    	    if ($kol==0)
    	    {
    		$kol = "-";
    	    }
       	
        $valzak = $zakaz[$did];
	$pr_zak = $pr_zak . " <TR bgcolor=#FFFFFF>	
	<TD align=left class=tmain>$name</TD>
	<TD align=middle class=tmain>$kol</TD>
	<TD align=middle class=tmain>$H</TD>
	<TD align=middle class=tmain>$W</TD>
	<TD align=middle class=tmain>$L</TD>
	<TD align=middle class=tmain>$cost</TD>
	<TD align=middle class=tmain>
		$valzak
	</TD>
	<TD align=middle class=tmain>$stoim</TD>
    </TR>";
    }
    $pr_zak = $pr_zak . "
    <TR bgcolor=#EEEEEE>
	    <TD colspan=8 align=right class=tmain>
		<b>Суммарная стоимость заказа:
		  &nbsp;&nbsp; $summ &nbsp; рублей</b>
	    </TD>
	</TR>
    </TABLE> 
    </TD></TABLE>";
    return $pr_zak;
}

function show_zakaz($zakaz,$page,$youname,$youmail,$youtel,$youmsg)
{
  global $CONF;
  $col_page = $CONF['col_page'];
  $from=$col_page*($page-1);
  
  $a=count($zakaz);
  
  $b=ceil($a/$col_page);
  echo "
  <table cellpadding=0 cellspacing=0 border=0 width=750 align=center>
  <td>
  <form action=catalog.php method=post >
  <table cellpadding=0 cellspacing=0 border=0 width=700 bgcolor=#999999 align=center>
	<TD>";  
  echo "    
	    <TABLE cellSpacing=1 cellPadding=5 border=0 width=100% class=tmain>
	    <TR bgcolor=#EEEEEE>
		<TD colspan=8>
		    <TABLE cellSpacing=0 cellPadding=0 border=0 width=100%>
		    <TR>
		    <TD width=95 class=tmain>
	    	    <b>&nbsp;От кого*:</b>
	    	    </TD>
		    <TD align = left>
			<input class=mreg type=text name='youname' size =88 value='$youname'>
		    </TD>
		    </TR>
		    </TABLE>
		</TD></TR>
		<TR bgcolor=#EEEEEE>
		<TD colspan=8>
		    <TABLE cellSpacing=0 cellPadding=0 border=0 width=100%>
		    <TR>
		    <TD width=95 class=tmain>
	    	    <b>&nbsp;E-mail*:</b>
	    	    </TD>
		    <TD align = left>
			<input class=mreg type=text name='youmail' size = 88 value='$youmail'>
		    </TD>
		    </TR>
		    </TABLE>
		</TD>
		</TR>
		
		<TR bgcolor=#EEEEEE>
		<TD colspan=8>
		    <TABLE cellSpacing=0 cellPadding=0 border=0 width=100%>
		    <TR>
		    <TD align=left width=95 class=tmain>
	    	    <b>&nbsp;Телефон:&nbsp;&nbsp;</b>
	    	    </TD>
		    <TD align = left>
			<input class=mreg type=text name='youtel' size = 88 value='$youtel'>
		    </TD>
		    </TR>
		    </TABLE>
		</TD>
		</TR>
		
		<TR bgcolor=#EEEEEE>
		<TD colspan=8>
		    <TABLE cellSpacing=0 cellPadding=0 border=0 width=100%>
		    <TR>
		    <TD width=95 class=tmain>
	    	    <b>&nbsp;Сообщение:</b>
	    	    </TD>
		    <TD align = left>
			<input class=mreg type=text name='youmsg' size = 88 value='$youmsg'>
		    </TD>
		    </TR>
		    </TABLE>
		</TD>
		</TR>
		<TR bgcolor=#EEEEEE>
		<TD colspan=8>
		    <TABLE cellSpacing=0 cellPadding=0 border=0 width=100%>
		    <TD align=left class=tmain>
		     &nbsp;&nbsp;* Поля обязательные для заполнения
		    </TD>
		    <TD align = right>&nbsp;
		    
		    </TD>
		    </TABLE>
		</TD>
	    </TR>
	    <TR bgcolor=#EEEEEE>
		<TD colspan=8>
		    <TABLE cellSpacing=0 cellPadding=0 border=0 width=100%>
		    <TD align=left class=tmain>
		    <b>Состав вашего заказа:</b>
		    </TD>
		    <TD align = right>&nbsp;
		    
		    </TD>
		    </TABLE>
		</TD>
	    </TR>
	    ";
    
 echo "
	<TR bgcolor=#EEEEEE>
	    <TD align=middle class=tmain rowspan=2><b>Артикул</b></TD>
	    <TD align=middle class=tmain rowspan=2><b>Кол-во<br>полок</b></TD>
	    <TD align=middle class=tmain colspan=3><b>Размеры, мм</b></TD>
	    <TD align=middle class=tmain rowspan=2><b>Цена,<br>руб.</b></TD>
	    <TD align=middle class=tmain rowspan=2><b>Заказ,<br>шт.</b></TD>
	    <TD align=middle class=tmain rowspan=2><b>Стоимость,<br>руб.</b></TD>
	</TR>
	<TR bgcolor=#EEEEEE>
	    <TD align=middle class=tmain><b>высота</b></TD>
	    <TD align=middle class=tmain><b>ширина</b></TD>
	    <TD align=middle class=tmain><b>глубина</b></TD>
	</TR>";
  if (0!=count($zakaz))
  {
     $keys = array_keys($zakaz);
#     echo count($zakaz);
  }
  $summ = 0;
  for ($i=0;$i<count($zakaz);$i++) 
  {

    	    $did = $keys[$i];
	    $sql2="select * from itek_data where did=$did";
    	    $res2=mysql_query($sql2);
	    	    
	    $result2=mysql_fetch_array($res2);
	    $name = $result2[name];
    	    $W     = $result2[W];
    	    $L     = $result2[L];
    	    $H     = $result2[H];
    	    $cost    = $result2[cost];
    	    $kol  = $result2[kol];
    	    $did   = $result2[did];
	    $stoim = $cost*$zakaz[$did];
	    $summ = $summ + $stoim;
       
    
       if ($W == "")
       {
    	   $W = "-";
       }
       if ($L==0)
       {
    	   $L = "-";
       }
       if ($H==0)
       {
    	   $H = "-";
       }
       if ($cost==0)
       {
    	   $cost = "-";
       }
       if ($kol==0)
       {
    	   $kol = "-";
       }
       	
        $valzak = $zakaz[$did];
	echo " <TR bgcolor=#FFFFFF>	
	<TD align=left class=tmain>$name</TD>
	<TD align=middle class=tmain>$kol</TD>
	<TD align=middle class=tmain>$H</TD>
	<TD align=middle class=tmain>$W</TD>
	<TD align=middle class=tmain>$L</TD>
	<TD align=middle class=tmain>$cost</TD>
	<TD align=middle class=tmain>
		<input type=hidden name=dzak[] value='$did'>
		<input class=mreg type=text name='zak[]' size = 3 value='$valzak'>
	</TD>
	<TD align=middle class=tmain>$stoim</TD>
    </TR>";
    
    }
    echo "
    <TR bgcolor=#EEEEEE>
	    <TD colspan=8 align=right class=tmain>
		<b>Суммарная стоимость заказа:
		  &nbsp;&nbsp; $summ &nbsp; рублей</b>
	    </TD>
	</TR>";
 
    echo "</TABLE> 
    </TD></TABLE> </div>";
    echo "<div align=right><br><input type=submit name=submit value='Пересчитать'>
		    <input type=submit name=submit value='Отправить'></div>
		    </form></td></table>";
    

}

function reg_var($var)
{
    session_start();

    if (!session_is_registered($var))
    {
	session_register($var);       
    }
}

function to_zakaz($zak,$dzak,$zakaz)
{
    for ($i=0;$i<count($zak);$i++)
    {
	if ($zak[$i]!="" &&  $zak[$i]>0)
	{
	    $zakaz[$dzak[$i]] = $zak[$i];
	}
	else
	  unset( $zakaz[$dzak[$i]]);
    }
    return $zakaz;
}

function to_filter($mfilt,$vfilt,$filt)
{
    for ($i=count($vfilt)-1;$i>=0;$i--)
    {
	  
	  if ($vfilt[$i]!="" ||  $vfilt[$i]>0)
	  {
	    $filt[$mfilt[$i]] = $vfilt[$i];
	  }
	  else
	    if ($mfilt[$i]!=0)
		unset( $filt[$mfilt[$i]]);
    }
    return $filt;
}

function clean_filter($filt)
{
    $keys = array_keys($filt); 
    for ($i=0;$i<count($keys);$i++)
    {
	if ($keys[$i]!=0)
    	  unset($filt[$keys[$i]]);
    }
    return $filt;
}

function db_connect()
{
     global $CONF;
     $db=mysql_connect($CONF['database_host'],$CONF['database_user'],$CONF['database_password']);
     if (!($db)) 
     {
        echo "Не удалось подключится к серверу БД!";
     } 
     else 
     {
         mysql_select_db($CONF['database_name'],$db);
         return $db;
     }
}

function show_catalog($page,$rid,$zakaz,$filt)
{
  global $CONF;
  $nzak = count($zakaz);
  echo "
	    <form action=catalog.php method=post > 
	";
		
  
  echo "    
  <TABLE cellSpacing=0 cellPadding=0 border=0 class=tmain width=750>
  <TR>
  <TD align=left valign=top>
       
      
	    <TABLE cellSpacing=0 cellPadding=4 border=0 class=tmain>
	    <TR>
		<TD>
			<IMG SRC=img/package.png>	
		</TD>
		<TD align=center>
               <a href='catalog.php?submit=Корзина'>
		    <b>Ваш заказ: </b><br>
		    $nzak шт.</a>
               
		</TD>
            
	    </TR>
	    </TABLE>
  </TD>
  <TD align=right>
	    <TABLE cellSpacing=0 cellPadding=0 border=0 class=tmain>";
  $keys = array_keys($filt); 
  for ($i=0;$i<count($filt);$i++)
  {
    
     echo    "<TR>
		<TD>";
		    if ($keys[$i]==0)
		    {
			echo "Фильтр по:&nbsp;&nbsp;&nbsp;&nbsp;";
		    }
		    else
		    {
			echo "&nbsp;";
		    }
		echo "</TD>
		<TD>";
		if ($keys[$i]==0)
		{
		    echo"
			<select name=mfilt[] class=mfilt>
			    <option value=1 "; if ($keys[$i]==1) echo "selected"; echo">&nbsp;Артикул&nbsp;</option>
			    <option value=2 "; if ($keys[$i]==2) echo "selected"; echo" >&nbsp;Кол-во полок&nbsp;</option>
			    <option value=3 "; if ($keys[$i]==3) echo "selected"; echo" >&nbsp;Высота&nbsp;</option>
			    <option value=4 "; if ($keys[$i]==4) echo "selected"; echo" >&nbsp;Ширина&nbsp;</option>
			    <option value=5 "; if ($keys[$i]==5) echo "selected"; echo" >&nbsp;Глубина&nbsp;</option>
			    <option value=6 "; if ($keys[$i]==6) echo "selected"; echo" >&nbsp;Цена&nbsp;</option>
			    <option value=0 "; if ($keys[$i]==0) echo "selected"; echo" >&nbsp;Не фильтровать&nbsp;</option>
			</select>";
		}
		else
		{
		    switch ($keys[$i]){
			case 1:
			    echo "<input type=hidden name=mfilt[] value='1'>";
			    echo "&nbsp;Артикул&nbsp;";
			    break;
			case 2:
			    echo "<input type=hidden name=mfilt[] value='2'>";
			    echo "&nbsp;Кол-во полок&nbsp;";
			    break;
			case 3:
			    echo "<input type=hidden name=mfilt[] value='3'>";
			    echo "&nbsp;Высота&nbsp;";
			    break;
			case 4:
			    echo "<input type=hidden name=mfilt[] value='4'>";
			    echo "&nbsp;Ширина&nbsp;";
			    break;
			case 5:
			    echo "<input type=hidden name=mfilt[] value='5'>";
			    echo "&nbsp;Глубина&nbsp;";
			    break;
			case 6:
			    echo "<input type=hidden name=mfilt[] value='6'>";
			    echo "&nbsp;Цена&nbsp;";
			    break;
		    }
		}
		echo "
		</TD>
		<TD>";
		$val_filt = $filt[$keys[$i]];
		 echo "
		<input class=mreg type=text name='vfilt[]' size = 15 value='$val_filt'>
		</TD>
		
	    </TR>";
    }
	     echo  "<TR>
		<TD>
		    &nbsp;
		</TD>
		<TD colspan = '2' align = right valign=middle height = 30> ";
		    echo "<input type=submit name=submit value=' OK '>
			<input type=submit name=submit value=' Очистить '>
		</TD>
		";
		
	    

echo"	    </TABLE>
	    </TD>
	    </TR>
	    </TABLE>
	    <BR>";


  $col_page = $CONF['col_page'];
  $from=$col_page*($page-1);
  if ($rid==0)
  {
     $sql="select * from itek_vitrina where rid=$rid order by 'rid' asc limit $from,$col_page ";
     $sql2="select * from itek_vitrina where rid=$rid";
  }
  else
  {
#    
#    SELECT * FROM itek_data, itek_sbor WHERE itek_data.did = itek_sbor.did and  itek_sbor.rid =1
# select itek_vitrina.* from itek_vitrina, itek_data where itek_vitrina.vid = itek_data.vid and itek_vitrina.rid = 1 and itek_data.name like '%1'
    $sql ="select distinct itek_vitrina.vid,itek_vitrina.* from itek_vitrina, itek_data where itek_vitrina.vid = itek_data.vid and itek_vitrina.rid = $rid ";
    $sql3 = "and itek_data.name like '%$filt[1]%'";
    for ($i=0;$i<count($keys);$i++)
    {
	$val_filt = $filt[$keys[$i]];
	switch ($keys[$i]){
		case 2:
		    $sql3=$sql3." and kol='$val_filt'";
		    break;
		case 3:
		    $sql3=$sql3." and H='$val_filt'";
		    break;
		case 4:
		    $sql3=$sql3." and W='$val_filt'";
		    break;
		case 5:
		    $sql3=$sql3." and L='$val_filt'";
		    break;
		case 6:
		    $sql3=$sql3." and cost='$val_filt'";
		    break;
	    }
    }
    
#    if ($S!="")
#    {
#	$sql=$sql." and S='$S'";
#    }
    $sql = $sql.$sql3;
    $sql2=$sql;
    $sql=$sql." order by 'rid' asc limit $from,$col_page ";
#    $sql=$sql." order by 'tid' asc limit $from,$col_page ";
  }
  
  $res=mysql_query($sql);
  
  $res2=mysql_query($sql2);
  $a=mysql_num_rows($res2);
  
  $b=ceil($a/$col_page);
  
  echo " 
  <table cellpadding=0 cellspacing=0 border=0 width=750 bgcolor=#999999 align=center>   
  <TR bgcolor=#f5f5f5>
    <TD>
	<TABLE cellSpacing=0 cellPadding=0 border=0>
	<TR>
	<TD class=tmain height=22>
	        &nbsp;&nbsp;&nbsp;&nbsp;
	</TD>
	
	";
	if (($rid==1) || ($rid>3 && $rid<7) )
        {
           echo"
	   <TD class=tmain width=7  background=";
	    if ($rid==1)
		echo "img/tab5.gif";
	    else 
	        echo "img/tab1.gif";
	    echo ">
	    </TD>
	    <TD background=img/tab2.gif class=mn";
	    if ($rid==1)
	       echo "b bgcolor=#ececec";
	    echo ">
		&nbsp;&nbsp;
                <a href='catalog.php?rid=1'>
                Металические
		</a>
		&nbsp;&nbsp;&nbsp;&nbsp;
	    </TD>
	    <TD class=tmain width=1  background=img/tab3.gif>
	    </TD>
	    <TD class=tmain width=7  background=";
	    if ($rid==4)
		echo "img/tab6.gif";
	    else 
	        echo "img/tab4.gif";
	    echo ">
		
	    </TD>
	    <TD background=img/tab2.gif class=mn";
	    if ($rid==4)
	       echo "b bgcolor=#ececec";
	    echo ">
		&nbsp;&nbsp;
		<a href='catalog.php?rid=4'>
                Гардеробные
                </a>
		&nbsp;&nbsp;&nbsp;&nbsp;
	    </TD>
	    <TD class=tmain width=1  background=img/tab3.gif>
	    </TD>

	    <TD class=tmain width=7  background=";
	    if ($rid==5)
		echo "img/tab6.gif";
	    else 
	        echo "img/tab4.gif";
	    echo ">
	    </TD>
	    <TD background=img/tab2.gif class=mn";
	    if ($rid==5)
	       echo "b bgcolor=#ececec";
	    echo ">
		&nbsp;&nbsp;
		<a href='catalog.php?rid=5'>
                Торговые
                </a>
		&nbsp;&nbsp;&nbsp;&nbsp;
	    </TD>
	    <TD class=tmain width=1  background=img/tab3.gif>
	    </TD>
	    <TD class=tmain width=7  background=";
	    if ($rid==6)
		echo "img/tab6.gif";
	    else 
	        echo "img/tab4.gif";
	    echo ">
	    </TD>
	    <TD background=img/tab2.gif class=mn";
	    if ($rid==6)
	       echo "b bgcolor=#ececec";
	    echo ">
		&nbsp;&nbsp;
		<a href='catalog.php?rid=6'>
                Грузовые
                </a>
		&nbsp;&nbsp;&nbsp;&nbsp;
	    </TD>
	    <TD class=tmain width=1  background=img/tab3.gif>
	    </TD>";
        }
	if ($rid==3 || $rid==7)
        {
           echo"
	   <TD class=tmain width=7  background=";
	    if ($rid==3)
		echo "img/tab5.gif";
	    else 
	        echo "img/tab1.gif";
	    echo ">
	    </TD>
	    <TD background=img/tab2.gif class=mn";
	    if ($rid==3)
	       echo "b bgcolor=#ececec";
	    echo ">
		&nbsp;&nbsp;
                <a href='catalog.php?rid=3'>
                Архивные
		</a>
		&nbsp;&nbsp;&nbsp;&nbsp;
	    </TD>
	    <TD class=tmain width=1  background=img/tab3.gif>
	    </TD>
	    <TD class=tmain width=7  background=";
	    if ($rid==7)
		echo "img/tab6.gif";
	    else 
	        echo "img/tab4.gif";
	    echo ">
	    </TD>
	    <TD background=img/tab2.gif class=mn";
	    if ($rid==7)
	       echo "b bgcolor=#ececec";
	    echo ">
	       	&nbsp;&nbsp;
		<a href='catalog.php?rid=7'>
                Для одежды
                </a>
		&nbsp;&nbsp;&nbsp;&nbsp;
	    </TD>
	    <TD class=tmain width=1  background=img/tab3.gif>
	    </TD>
             ";
        }
	
	if ($rid==2 || $rid==8)
        {
           echo"
	   <TD class=tmain width=7  background=";
	    if ($rid==2)
		echo "img/tab5.gif";
	    else 
	        echo "img/tab1.gif";
	    echo ">
	    </TD>
	    <TD background=img/tab2.gif class=mn";
	    if ($rid==2)
	       echo "b bgcolor=#ececec";
	    echo ">
		&nbsp;&nbsp;
                <a href='catalog.php?rid=2'>
                Из металла
		</a>
		&nbsp;&nbsp;&nbsp;&nbsp;
	    </TD>
	    <TD class=tmain width=1  background=img/tab3.gif>
	    </TD>
	    <TD class=tmain width=7  background=";
	    if ($rid==8)
		echo "img/tab6.gif";
	    else 
	        echo "img/tab4.gif";
	    echo ">
	    </TD>
	    <TD background=img/tab2.gif class=mn";
	    if ($rid==8)
	       echo "b bgcolor=#ececec";
	    echo ">
		&nbsp;&nbsp;
		<a href='catalog.php?rid=8'>
                Из профиля
                </a>
		&nbsp;&nbsp;&nbsp;&nbsp;
	    </TD>
	    <TD class=tmain width=1  background=img/tab3.gif>
	    </TD>
             ";
        }
	echo "
	</TR>
	</TABLE>
    </TD>
  </TR>
  
  <tr>
    <td>
	    <TABLE cellSpacing=1 cellPadding=5 border=0 width=100%>
	    
	    
	    <TR bgcolor=#EEEEEE>
		<TD colspan=8>
		    <TABLE cellSpacing=0 cellPadding=0 border=0 width=100%>
		    <TD width=60% class=tmain>
			<b>Страницы: </b>"; 	
		    
  
  for ($i=1; $i<=$b; $i++) 
  {
    if ($i!=$page) 
    {
      echo "<a href=catalog.php?rid=$rid&page=$i>";
    } 
    echo "<b>$i</b>"; 
    if ($i!=$page) 
    {
      echo "</a>";
    } 
    echo " ";
  }
  echo"</TD><TD width = 40% align = right class=tmain><b>";
  if ($page!=1)
  { 
    $p = $page-1;
    echo "<a href=catalog.php?rid=$rid&page=$p>";
    echo "<Пред.</a>";
  }
  else
  {
    echo "<font class=tmain><Пред.</font>";
  }
  echo " | " ;
#  echo "<font class=tmain>Поиск</font>";
#  echo " | " ;
  
  if ($page!=$b)
  { 
    $p = $page+1;
    echo "<a href=catalog.php?rid=$rid&page=$p>";
    echo "След.></a>";
  }
  else
  {
    echo "<font class=tmain>След.></font>";
  }
  echo "</b>		
	</TD></TABLE>
	</TD>
    </TR>";
    
  $old_vid = 0;
  
  while($result=mysql_fetch_array($res))
  {
       
       $head = $result[name];        
       $vid = $result[vid];        
       $img = $result[img];        
       $desc = $result[desc];
       $note = $result[note];
  
       
       
	echo "
	<TR bgcolor=#EEEEEE>
	    <TD colspan=8 align=middle class=tmain>
		<b>
		    $head
		</b>
	    </TD>
	</TR>";
	if ($desc != "")
	echo "
	<TR bgcolor=#EEEEEE>
	    <TD colspan=8 align=middle class=tmain>
		    $desc
	    </TD>
	</TR>
	";

    
	
#	$sql1="select * from itek_sbor where vid=$vid";
#        $res1=mysql_query($sql1);
	
        $sql2="select * from itek_data where vid=$vid ".$sql3;
    	$res2=mysql_query($sql2);
	$num_row=mysql_num_rows($res2);
	$num_row = $num_row+2;
	
	while($result2=mysql_fetch_array($res2))
	{
    	    $did = $result2[did];
	    
#	    $result2=mysql_fetch_array($res2);
	    $name = $result2[name];
    	    $W     = $result2[W];
    	    $L     = $result2[L];
    	    $H     = $result2[H];
    	    $cost    = $result2[cost];
    	    $kol  = $result2[kol];
    	    $did   = $result2[did];
       
    
       if ($W == 0)
       {
    	   $W = "-";
       }
       if ($L==0)
       {
    	   $L = "-";
       }
       if ($H==0)
       {
    	   $H = "-";
       }
       if ($cost==0)
       {
    	   $cost = "-";
       }
       if ($kol==0)
       {
    	   $kol = "-";
       }
       
       
	
	if ($vid != $old_vid)
        {
	
	echo "
	<TR bgcolor=#EEEEEE>
	    <TD align=middle bgcolor=#FFFFFF  class=tmain rowspan=$num_row width=25%>
		<IMG SRC=upimg/$img>
	    </TD>
	    <TD align=middle class=tmain rowspan=2 width=40%><b>Артикул</b></TD>
	    <TD align=middle class=tmain rowspan=2><b>Кол-во<br>полок</b></TD>
	    <TD align=middle class=tmain colspan=3><b>Размеры, мм</b></TD>
	    <TD align=middle class=tmain rowspan=2><b>Цена,<br>руб.</b></TD>
	    <TD align=middle class=tmain rowspan=2><b>Заказ,<br>шт.</b></TD>
	</TR>
	<TR bgcolor=#EEEEEE>
	    <TD align=middle class=tmain><b>высота</b></TD>
	    <TD align=middle class=tmain><b>ширина</b></TD>
	    <TD align=middle class=tmain><b>глубина</b></TD>
	</TR>";

	}
	if ($zakaz[$did]>0)
	    $valzak = $zakaz[$did];
	else
	    $valzak="";
	echo " <TR bgcolor=#FFFFFF>	
	<TD align=left class=tmain>$name</TD>
	<TD align=middle class=tmain>$kol</TD>
	<TD align=middle class=tmain>$H</TD>
	<TD align=middle class=tmain>$W</TD>
	<TD align=middle class=tmain>$L</TD>
	<TD align=middle class=tmain>$cost</TD>
	<TD align=middle class=tmain>
		<input type=hidden name=dzak[] value='$did'>
		<input class=mreg type=text name='zak[]' size = 3 value='$valzak'>
	</TD>
    </TR>";
    
	
    $old_vid = $vid;
    }
    if ($note != "")
    echo "
    <TR bgcolor=#EEEEEE>
	    <TD colspan=8 align=left class=tmain>
	    $note
	    </TD>
	</TR>";
 }
    echo "
    <TR bgcolor=#EEEEEE>
	    <TD colspan=8 align=right class=tmain height= 30>
		<input type=hidden name=rid value='$rid'>
		<input type=submit name=submit value='Добавить'>
	    </TD>
	</TR>";
    echo "</TABLE> 
    </td></tr></table> </form>";
    
}  

function show_table($page,$rid,$zakaz,$filt)
{
    if (!isset($rid)) 
    {
	$rid=1;
    }
    if (!isset($page)) 
    {
	$page=1;
    }

    if ($rid!=0)
    {
	$sql4="select * from itek_razdel where rid=$rid";
        $res4=mysql_query($sql4);
	$result4=mysql_fetch_array($res4);
# $h = $result4[name]; 
	show_catalog($page,$rid,$zakaz,$filt);
    }
    else
    { 
	$h = "Поиск детали";
	echo "
	    <table cellpadding=0 cellspacing=0 border=0 width=100% bgcolor=#999999 align=center>
	    <TD>";
	show_catalog($page,$rid,$zakaz,$filt);
    }

}


function in_catalog($page,$rid,$zakaz,$filt)
{
  global $CONF;
  
  
  if (!isset($rid)) 
    {
	$rid=1;
    }
    if (!isset($page)) 
    {
	$page=1;
    }
  
  echo "    <div align=right>
	    <form enctype='multipart/form-data' action='cat.php' method='post'>
	    <TABLE cellSpacing=0 cellPadding=0 border=0 class=tmain>";
  $keys = array_keys($filt); 
  for ($i=0;$i<count($filt);$i++)
  {
    
     echo    "<TR>
		<TD>";
		    if ($keys[$i]==0)
		    {
			echo "Фильтр по:&nbsp;&nbsp;&nbsp;&nbsp;";
		    }
		    else
		    {
			echo "&nbsp;";
		    }
		echo "</TD>
		<TD>";
		if ($keys[$i]==0)
		{
		    echo"
			<select name=mfilt[] class=mfilt>
			    <option value=1 "; if ($keys[$i]==1) echo "selected"; echo">&nbsp;Артикул&nbsp;</option>
			    <option value=2 "; if ($keys[$i]==2) echo "selected"; echo" >&nbsp;Кол-во полок&nbsp;</option>
			    <option value=3 "; if ($keys[$i]==3) echo "selected"; echo" >&nbsp;Высота&nbsp;</option>
			    <option value=4 "; if ($keys[$i]==4) echo "selected"; echo" >&nbsp;Ширина&nbsp;</option>
			    <option value=5 "; if ($keys[$i]==5) echo "selected"; echo" >&nbsp;Глубина&nbsp;</option>
			    <option value=6 "; if ($keys[$i]==6) echo "selected"; echo" >&nbsp;Цена&nbsp;</option>
			    <option value=0 "; if ($keys[$i]==0) echo "selected"; echo" >&nbsp;Не фильтровать&nbsp;</option>
			</select>";
		}
		else
		{
		    switch ($keys[$i]){
			case 1:
			    echo "<input type=hidden name=mfilt[] value='1'>";
			    echo "&nbsp;Артикул&nbsp;";
			    break;
			case 2:
			    echo "<input type=hidden name=mfilt[] value='2'>";
			    echo "&nbsp;Кол-во полок&nbsp;";
			    break;
			case 3:
			    echo "<input type=hidden name=mfilt[] value='3'>";
			    echo "&nbsp;Высота&nbsp;";
			    break;
			case 4:
			    echo "<input type=hidden name=mfilt[] value='4'>";
			    echo "&nbsp;Ширина&nbsp;";
			    break;
			case 5:
			    echo "<input type=hidden name=mfilt[] value='5'>";
			    echo "&nbsp;Глубина&nbsp;";
			    break;
			case 6:
			    echo "<input type=hidden name=mfilt[] value='6'>";
			    echo "&nbsp;Цена&nbsp;";
			    break;
		    }
		}
		echo "
		</TD>
		<TD>";
		$val_filt = $filt[$keys[$i]];
		 echo "
		<input class=mreg type=text name='vfilt[]' size = 15 value='$val_filt'>
		</TD>
		
	    </TR>";
    }
	     echo  "<TR>
		<TD>
		    &nbsp;
		</TD>
		<TD colspan = '2' align = right valign=middle height = 30> ";
		    echo "<input type=submit name=submit value=' OK '>
			<input type=submit name=submit value=' Очистить '>
		</TD>
		";
		
	    

echo"	    </TABLE>
	    </div>
	    <BR>";


  $col_page = $CONF['col_page'];
  $from=$col_page*($page-1);
  if ($rid==0)
  {
     $sql="select * from itek_vitrina where rid=$rid order by 'rid' asc limit $from,$col_page ";
     $sql2="select * from itek_vitrina where rid=$rid";
  }
  else
  {
#    
#    SELECT * FROM itek_data, itek_sbor WHERE itek_data.did = itek_sbor.did and  itek_sbor.rid =1
# select itek_vitrina.* from itek_vitrina, itek_data where itek_vitrina.vid = itek_data.vid and itek_vitrina.rid = 1 and itek_data.name like '%1'
    $sql ="select distinct itek_vitrina.vid,itek_vitrina.* from itek_vitrina, itek_data where itek_vitrina.vid = itek_data.vid and itek_vitrina.rid = $rid ";
    $sql3 = "and itek_data.name like '%$filt[1]%'";
    for ($i=0;$i<count($keys);$i++)
    {
	$val_filt = $filt[$keys[$i]];
	switch ($keys[$i]){
		case 2:
		    $sql3=$sql3." and kol='$val_filt'";
		    break;
		case 3:
		    $sql3=$sql3." and H='$val_filt'";
		    break;
		case 4:
		    $sql3=$sql3." and W='$val_filt'";
		    break;
		case 5:
		    $sql3=$sql3." and L='$val_filt'";
		    break;
		case 6:
		    $sql3=$sql3." and cost='$val_filt'";
		    break;
	    }
    }
    
#    if ($S!="")
#    {
#	$sql=$sql." and S='$S'";
#    }
    $sql = $sql.$sql3;
    $sql2=$sql;
    $sql=$sql." order by 'rid' asc limit $from,$col_page ";
#    $sql=$sql." order by 'tid' asc limit $from,$col_page ";
  }
  
  $res=mysql_query($sql);
  
  $res2=mysql_query($sql2);
  $a=mysql_num_rows($res2);
  
  $b=ceil($a/$col_page);
  
  echo " 
  <table cellpadding=0 cellspacing=0 border=0 width=100% bgcolor=#999999 align=center>   
  <TR bgcolor=#f5f5f5>
    <TD>
	<TABLE cellSpacing=0 cellPadding=0 border=0>
	<TR>
	<TD class=tmain>
	        &nbsp;&nbsp;&nbsp;&nbsp;
	</TD>
	
	";
	if (($rid==1) || ($rid>3 && $rid<7) )
        {
           echo"
	   <TD class=tmain>	     
	        <IMG SRC=";
	    if ($rid==1)
		echo "../img/tab5.gif";
	    else 
	        echo "../img/tab1.gif";
	    echo ">
	    </TD>
	    <TD background=../img/tab2.gif class=mn";
	    if ($rid==1)
	       echo "b bgcolor=#ececec";
	    echo ">
		&nbsp;&nbsp;
                <a href='cat.php?rid=1'>
                Металические
		</a>
		&nbsp;&nbsp;&nbsp;&nbsp;
	    </TD>
	    <TD class=tmain>
		<IMG SRC=../img/tab3.gif>
	    </TD>
	    <TD class=tmain>
	        <IMG SRC=";
	    if ($rid==4)
		echo "../img/tab6.gif";
	    else 
	        echo "../img/tab4.gif";
	    echo ">
		
	    </TD>
	    <TD background=../img/tab2.gif class=mn";
	    if ($rid==4)
	       echo "b bgcolor=#ececec";
	    echo ">
		&nbsp;&nbsp;
		<a href='cat.php?rid=4'>
                Гардеробные
                </a>
		&nbsp;&nbsp;&nbsp;&nbsp;
	    </TD>
	    <TD class=tmain>
		<IMG SRC=../img/tab3.gif>
	    </TD>
	    <TD class=tmain>
	        <IMG SRC=";
	    if ($rid==5)
		echo "../img/tab6.gif";
	    else 
	        echo "../img/tab4.gif";
	    echo ">
	    </TD>
	    <TD background=../img/tab2.gif class=mn";
	    if ($rid==5)
	       echo "b bgcolor=#ececec";
	    echo ">
		&nbsp;&nbsp;
		<a href='cat.php?rid=5'>
                Торговые
                </a>
		&nbsp;&nbsp;&nbsp;&nbsp;
	    </TD>
	    <TD class=tmain>
		<IMG SRC=../img/tab3.gif>
	    </TD>
	    <TD class=tmain>
	        <IMG SRC=";
	    if ($rid==6)
		echo "../img/tab6.gif";
	    else 
	        echo "../img/tab4.gif";
	    echo ">
	    </TD>
	    <TD background=../img/tab2.gif class=mn";
	    if ($rid==6)
	       echo "b bgcolor=#ececec";
	    echo ">
		&nbsp;&nbsp;
		<a href='cat.php?rid=6'>
                Грузовые
                </a>
		&nbsp;&nbsp;&nbsp;&nbsp;
	    </TD>
	    <TD class=tmain>
		<IMG SRC=../img/tab3.gif>
	    </TD>
             ";
        }
	if ($rid==3 || $rid==7)
        {
           echo"
	   <TD class=tmain>
	        <IMG SRC=";
	    if ($rid==3)
		echo "../img/tab5.gif";
	    else 
	        echo "../img/tab1.gif";
	    echo ">
	    </TD>
	    <TD background=../img/tab2.gif class=mn";
	    if ($rid==3)
	       echo "b bgcolor=#ececec";
	    echo ">
		&nbsp;&nbsp;
                <a href='cat.php?rid=3'>
                Архивные
		</a>
		&nbsp;&nbsp;&nbsp;&nbsp;
	    </TD>
	    <TD class=tmain>
		<IMG SRC=../img/tab3.gif>
	    </TD>
	    <TD class=tmain>
	        <IMG SRC=";
	    if ($rid==7)
		echo "../img/tab6.gif";
	    else 
	        echo "../img/tab4.gif";
	    echo ">
	    </TD>
	    <TD background=../img/tab2.gif class=mn";
	    if ($rid==7)
	       echo "b bgcolor=#ececec";
	    echo ">
	       	&nbsp;&nbsp;
		<a href='cat.php?rid=7'>
                Для одежды
                </a>
		&nbsp;&nbsp;&nbsp;&nbsp;
	    </TD>
	    <TD class=tmain>
		<IMG SRC=../img/tab3.gif>
	    </TD>
             ";
        }
	
	if ($rid==2 || $rid==8)
        {
           echo"
	   <TD class=tmain>
	        <IMG SRC=";
	    if ($rid==2)
		echo "../img/tab5.gif";
	    else 
	        echo "../img/tab1.gif";
	    echo ">
	    </TD>
	    <TD background=../img/tab2.gif class=mn";
	    if ($rid==2)
	       echo "b bgcolor=#ececec";
	    echo ">
		&nbsp;&nbsp;
                <a href='cat.php?rid=2'>
                Из металла
		</a>
		&nbsp;&nbsp;&nbsp;&nbsp;
	    </TD>
	    <TD class=tmain>
		<IMG SRC=../img/tab3.gif>
	    </TD>
	    <TD class=tmain>
	        <IMG SRC=";
	    if ($rid==8)
		echo "../img/tab6.gif";
	    else 
	        echo "../img/tab4.gif";
	    echo ">
	    </TD>
	    <TD background=../img/tab2.gif class=mn";
	    if ($rid==8)
	       echo "b bgcolor=#ececec";
	    echo ">
		&nbsp;&nbsp;
		<a href='cat.php?rid=8'>
                Из профиля
                </a>
		&nbsp;&nbsp;&nbsp;&nbsp;
	    </TD>
	    <TD class=tmain>
		<IMG SRC=../img/tab3.gif>
	    </TD>
             ";
        }
	echo "
	</TR>
	</TABLE>
    </TD>
  </TR>
  <tr>
    <td>
  
  
	    <TABLE cellSpacing=1 cellPadding=5 border=0 width=100%>
	    <TR bgcolor=#EEEEEE>
		<TD colspan=8>
		    <TABLE cellSpacing=0 cellPadding=0 border=0 width=100%>
		    <TD width=60% class=tmain>
			<b>Страницы: </b>"; 	
		    
  
  for ($i=1; $i<=$b; $i++) 
  {
    if ($i!=$page) 
    {
      echo "<a href=cat.php?rid=$rid&page=$i>";
      
    } 
    echo "<b>$i</b>"; 
    if ($i!=$page) 
    {
      echo "</a>";
    } 
    echo " ";
  }
  echo"</TD><TD width = 40% align = right class=tmain><b>";
  if ($page!=1)
  { 
    $p = $page-1;
    echo "<a href=cat.php?rid=$rid&page=$p>";
    echo "<Пред.</a>";
  }
  else
  {
    echo "<font class=tmain><Пред.</font>";
  }
  echo " | " ;
#  echo "<font class=tmain>Поиск</font>";
#  echo " | " ;
  
  if ($page!=$b)
  { 
    $p = $page+1;
    echo "<a href=cat.php?rid=$rid&page=$p>";
    echo "След.></a>";
  }
  else
  {
    echo "<font class=tmain>След.></font>";
  }
  echo "</b>		
	</TD></TABLE>
	</TD>
    </TR>";
    
  $old_vid = 0;
  
  while($result=mysql_fetch_array($res))
  {
       
       $head = $result[name];        
       $vid = $result[vid];        
       $img = $result[img];        
       $desc = $result[desc];
       $note = $result[note];
  
	echo "
	<TR bgcolor=#EEEEEE>
	    <TD colspan=7 align=middle class=tmain>
		<b>
		    <input class=mhead type=text name='ihead[]' size =100 value='$head'>
		    
		</b>
	    </TD>
	</TR>";
#	if ($desc != "")
	echo "
	<TR bgcolor=#EEEEEE>
	    <TD colspan=7 align=middle class=tmain>
		<input class=mreg type=text name='idesc[]' size =100 value='$desc'>
	    </TD>
	</TR>
	";

    
	
#	$sql1="select * from itek_sbor where vid=$vid";
#        $res1=mysql_query($sql1);
	
        $sql2="select * from itek_data where vid=$vid ".$sql3;
    	$res2=mysql_query($sql2);
	$num_row=mysql_num_rows($res2);
	$num_row = $num_row+2;
	
	while($result2=mysql_fetch_array($res2))
	{
    	    $did = $result2[did];
	    
#	    $result2=mysql_fetch_array($res2);
	    $name = $result2[name];
    	    $W     = $result2[W];
    	    $L     = $result2[L];
    	    $H     = $result2[H];
    	    $cost    = $result2[cost];
    	    $kol  = $result2[kol];
    	    $did   = $result2[did];
       
    
	
	if ($vid != $old_vid)
        {
	
	echo "
	<TR bgcolor=#EEEEEE>
	    <TD align=middle bgcolor=#FFFFFF  class=tmain>
		<input type='hidden' name='MAX_FILE_SIZE' value='100000'>
                <input name='iimg[]' type='file' size=10>
	    </TD>
	    <TD align=middle class=tmain rowspan=2><b>Артикул</b></TD>
	    <TD align=middle class=tmain rowspan=2><b>Кол-во<br>полок</b></TD>
	    <TD align=middle class=tmain colspan=3><b>Размеры, мм</b></TD>
	    <TD align=middle class=tmain rowspan=2><b>Цена,<br>руб.</b></TD>
	</TR>
	<TR bgcolor=#EEEEEE>
	    <TD align=middle bgcolor=#FFFFFF  class=tmain rowspan=$num_row>
		<IMG SRC=../upimg/$img>
	    </TD>
	    <TD align=middle class=tmain><b>высота</b></TD>
	    <TD align=middle class=tmain><b>ширина</b></TD>
	    <TD align=middle class=tmain><b>глубина</b></TD>
	</TR>";

	}
	if ($zakaz[$did]>0)
	    $valzak = $zakaz[$did];
	else
	    $valzak="";
	echo " <TR bgcolor=#FFFFFF>	
	<TD align=middle class=tmain>
	    <input class=mreg type=text name='iname[]' size =35 value='$name'>
	</TD>
	<TD align=middle class=tmain>
	    <input class=mreg type=text name='ikol[]' size =4 value='$kol'>
	</TD>
	<TD align=middle class=tmain>
	    <input class=mreg type=text name='iH[]' size =4 value='$H'>
	</TD>
	<TD align=middle class=tmain>
	    <input class=mreg type=text name='iW[]' size =4 value='$W'>
	</TD>
	<TD align=middle class=tmain>
	    <input class=mreg type=text name='iL[]' size =4 value='$L'>
	</TD>
	<TD align=middle class=tmain>
	    <input class=mreg type=text name='icost[]' size =6 value='$cost'>
	    <input type=hidden name=ddid[] value='$did'>
	    
	</TD>
    </TR>";
    
    $old_vid = $vid;
    }
#    if ($note != "")
          echo " <TR bgcolor=#FFFFFF>	
	<TD align=middle class=tmain>
	    <input class=mreg type=text name='nname[]' size =35 value=''>
	</TD>
	<TD align=middle class=tmain>
	    <input class=mreg type=text name='nkol[]' size =4 value=''>
	</TD>
	<TD align=middle class=tmain>
	    <input class=mreg type=text name='nH[]' size =4 value=''>
	</TD>
	<TD align=middle class=tmain>
	    <input class=mreg type=text name='nW[]' size =4 value=''>
	</TD>
	<TD align=middle class=tmain>
	    <input class=mreg type=text name='nL[]' size =4 value=''>
	</TD>
	<TD align=middle class=tmain>
	    <input class=mreg type=text name='ncost[]' size =6 value=''>
	    <input type=hidden name=nvid[] value='$vid'>
	</TD>
    </TR>";
    echo "
    <TR bgcolor=#EEEEEE>
	    <TD colspan=7 align=center class=tmain>
	    <textarea class=mnote cols=100 rows=3 name='inote[]'>$note</textarea>
	    <input type=hidden name=ivid[] value='$vid'>
	    </TD>
	</TR>";
 }
    	echo "
	<TR bgcolor=#EEEEEE>
	    <TD colspan=7 align=middle class=tmain>
		<b>
		    <input class=mhead type=text name='nhead[]' size =100 value=''>
		</b>
	    </TD>
	</TR>";
#	if ($desc != "")
	echo "
	<TR bgcolor=#EEEEEE>
	    <TD colspan=7 align=middle class=tmain>
		<input class=mreg type=text name='ndesc[]' size =100 value=''>
	    </TD>
	</TR>
	
	    <TR bgcolor=#EEEEEE>
	    <TD align=middle bgcolor=#FFFFFF  class=tmain>
		<input type='hidden' name='MAX_FILE_SIZE' value='100000'>
                <input name='nimg[]' type='file' size=10>
	    </TD>
	    <TD align=middle class=tmain rowspan=2><b>Артикул</b></TD>
	    <TD align=middle class=tmain rowspan=2><b>Кол-во<br>полок</b></TD>
	    <TD align=middle class=tmain colspan=3><b>Размеры, мм</b></TD>
	    <TD align=middle class=tmain rowspan=2><b>Цена,<br>руб.</b></TD>
	</TR>
	<TR bgcolor=#EEEEEE>
	    <TD align=middle bgcolor=#FFFFFF  class=tmain rowspan=4>
		&nbsp;
	    </TD>
	    <TD align=middle class=tmain><b>высота</b></TD>
	    <TD align=middle class=tmain><b>ширина</b></TD>
	    <TD align=middle class=tmain><b>глубина</b></TD>
	</TR>";
	for ($i=1;$i<=3;$i++)
	
	 echo " <TR bgcolor=#FFFFFF>	
	<TD align=middle class=tmain>
	    -
	</TD>
	<TD align=middle class=tmain>
	    -
	</TD>
	<TD align=middle class=tmain>
	    -
	</TD>
	<TD align=middle class=tmain>
	    -
	</TD>
	<TD align=middle class=tmain>
	  -
	</TD>
	<TD align=middle class=tmain>
	  -
	</TD>
    </TR>";
    echo "
    <TR bgcolor=#EEEEEE>
	    <TD colspan=7 align=center class=tmain>
	    <textarea class=mnote cols=100 rows=3 name='nnote[]'></textarea>
	    <input type=hidden name=rid value='$rid'>
	    
	    </TD>
	</TR>";

    echo "
    <TR bgcolor=#EEEEEE>
	    <TD colspan=7 align=right class=tmain height= 30>
		<input type=submit name=submit value='Обновить'>
		<input type=hidden name=page value='$page'>
	    </TD>
	</TR>";
    echo "</TABLE> </form>
    
    </td></tr></table>";
    

}

function to_baze($ddid,$iname,$ikol,$iH,$iW,$iL,$icost)
{
    for ($i=0;$i<count($iname);$i++)
    {
	if ($iname[$i]!="")
	{
	    if ($iW[$i]=="")
		$iW[$i]=0;
	    if ($iH[$i]=="")
		$iH[$i]=0;
	    if ($iL[$i]=="")
	    	$iL[$i]=0;
	    if ($icost[$i]=="")
	    	$icost[$i]=0;
	    if ($ikol[$i]=="")
	    	$ikol[$i]=0;
	
	    $sql="update itek_data set name='$iname[$i]', W=$iW[$i], H=$iH[$i], L=$iL[$i], cost=$icost[$i], kol=$ikol[$i]  where did=$ddid[$i];"; 
	    $a=mysql_query($sql); 
	    # $ar=mysql_error($db); 
	    if(!$a) { 
    		echo "<font color=blue>[ERROR] $ar</font>";
	    } 
	}
	else
	{
	    $sql="delete from itek_data where did=$ddid[$i];"; 
	    $a=mysql_query($sql); 
	    $ar=mysql_error($db); 
	    if(!$a) { 
    		echo "<font color=blue>[ERROR] $ar</font>";
	    } 
	}
    }
    
}

function to_vitrina($ivid,$ihead,$iimg,$idesc,$inote)
{
    global $CONF;
    for ($i=0;$i<count($ivid);$i++)
    {
	 if ($ihead[$i]!="")
	 {
	    $upfile = "";
	    if (is_uploaded_file($_FILES['iimg']['tmp_name'][$i])) 
	    {
#		$upfile =$_FILES['iimg']['name'][$i];
		$upfile = "img".$ivid[$i].".jpg";
	        move_uploaded_file($_FILES['iimg']['tmp_name'][$i], $CONF['img_upload']."$upfile");
    		$sql="update itek_vitrina set name='$ihead[$i]', img='$upfile', note='$inote[$i]', `desc` = '$idesc[$i]' where vid=$ivid[$i];"; 
	    }
	    else
	       $sql="update itek_vitrina set name='$ihead[$i]', note='$inote[$i]', `desc` = '$idesc[$i]' where vid=$ivid[$i];"; 	
	    $a=mysql_query($sql); 
#	    $ar=mysql_error($db); 
	    if(!$a) { 
    		echo "<font color=blue>[ERROR] $ar</font>";
	    } 
	}
	else
	{
	    $sql="delete from itek_data where vid=$ivid[$i];"; 
	    $a=mysql_query($sql); 
#	    $ar=mysql_error($db); 
	    if(!$a) { 
    		echo "<font color=blue>[ERROR] $ar</font>";
	    }
	    
	    $sql="delete from itek_vitrina where vid=$ivid[$i];"; 
	    $a=mysql_query($sql); 
#	    $ar=mysql_error($db); 
	    if(!$a) { 
    		echo "<font color=blue>[ERROR] $ar</font>";
	    }
	}
	    
    }
}

function ins_vitrina($ihead,$nimg,$idesc,$inote,$rid)
{
    $ret=0;
    for ($i=0;$i<count($ihead);$i++)
    {
	if ($ihead[$i]!="")
	{
	
	    $sql2="select max(vid) from itek_vitrina";
    	    $res2=mysql_query($sql2);
	    	    
	    $result2=mysql_fetch_array($res2);
	    $vid = $result2[0]+1;
	    
	    $upfile = "";
	    
	    if (is_uploaded_file($_FILES['nimg']['tmp_name'][$i])) 
	    {
#		$upfile =$_FILES['nimg']['name'][$i];
		$upfile ="img".$vid.".jpg";
		move_uploaded_file($_FILES['nimg']['tmp_name'][$i], $CONF['img_upload']."$upfile");
		echo $upfile;
	    }
	
	    $sql="insert into itek_vitrina values (null,'$ihead[$i]','$upfile',$rid,'$idesc[$i]','$inote[$i]')"; 
	    $a=mysql_query($sql); 
#	    $ar=mysql_error($db); 
	    if(!$a) { 
    		echo "<font color=blue>[ERROR] $ar</font>";
	    } 
	    
	    
	    $sql2="select max(vid) from itek_vitrina";
    	    $res2=mysql_query($sql2);
	    	    
	    $result2=mysql_fetch_array($res2);
	    $vid = $result2[0];
	    $sql="insert into itek_data values (null,'-',0,0,0,0,0,$vid)"; 
	    $a=mysql_query($sql); 
#	    $ar=mysql_error($db); 
	    if(!$a) { 
    		echo "<font color=blue>[ERROR] $ar</font>";
	    }
	    $ret = 1;
	}
    }
    return $ret;
}

function ins_baze($ddid,$iname,$ikol,$iH,$iW,$iL,$icost,$ivid)
{
    for ($i=0;$i<count($iname);$i++)
    {
	if ($iname[$i]!="")	    
	{
	    if ($iW[$i]=="")
		$iW[$i]=0;
	    if ($iH[$i]=="")
		$iH[$i]=0;
	    if ($iL[$i]=="")
	    	$iL[$i]=0;
	    if ($icost[$i]=="")
	    	$icost[$i]=0;
	    if ($ikol[$i]=="")
	    	$ikol[$i]=0;
	    
	    $sql="insert into itek_data values (null,'$iname[$i]',$iW[$i],$iH[$i],$iL[$i],$icost[$i],$ikol[$i],$ivid[$i])"; 
	    $a=mysql_query($sql); 
	    $ar=mysql_error($db); 
	    if(!$a) { 
    		echo "<font color=blue>[ERROR] $ar</font>";
	    } 
	}
    }
    
}

function clean_zakaz($zakaz)
{
    for ($i=0;$i<count($zakaz);$i++)
    {
	  unset($zakaz[$i]);
    }
    unset($zakaz);
    return $zakaz;
}

?>
