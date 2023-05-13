<!doctype html>
<html lang="ru">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <meta name=viewport content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Upload1</title>
 </head>
 <style>
     body {
         background: url(../../files/film1.jpg);
     }
     table {
      background: #ececec;
      border: 2px solid;
      border-collapse: collapse;
     }
     th, td {
     	border: 1px solid #dcdcdc;
     }
     td:first-child {
     	background: #ecfcec;
     }
     tr:nth-child(2n) {
     	background: #e0ece0;
     }
     .t1 {
     	font-size: 22px;
     	color: #105f10;
     }
     .t2 {
        color: #105f10;
        background-color: #e8e8e8;
        font-size: 22px;
     	border: solid 1px;
     }
     .t3 {
     	color: #105f10;
     	background: #e8e8e8;
     	background-color: #FE8020;
     	font-size: 16px;
     }
     .d1 {
     	background-color: #e8e8e8;
     	color: #105f10;
     	border-style: double;
     	width: 50%;
     }
 </style>
<script>
 var stdr1 = "";
 function cltd(p1) {
 	 var dr1 = document.getElementsByName( "dir1" );
 	 if(stdr1 == "") { stdr1 = dr1[0].value; }
 	 dr1[0].value = stdr1 + p1;
 }
 function sel1(np) {
    //let s1=document.getElementById("cmid");
 	//confirm("Команда " + s1[np].value + " ?");
 	if(np != "command" && confirm("Команда " + np + " ?")) {
 		if(!confirm("Выполнить команду " + np + " ?")) { document.getElementById("cmid").selectedIndex = "0"; }
 	} else {
 		document.getElementById("cmid").selectedIndex = "0";
 	}
 	return;
 }
 //var etd = document.getElementsByTagName('td');
 //alert (etd.length);
 //for (var i=0; i<etd.length; i++) { etd[i].onclick = cltd; }
</script>
 <body style='font-size: 25px;'>
<?php
 //echo "Test 2021_11_19 ===";
 clearstatcache();
 //$firdir='/home/vol2_5/xenn.xyz/xnnx_29523285/htdocs/fot/upload/';
 $firdir='../../';
 $newdir=$_POST["dir1"];
 $cmdt=$_POST["cmd1"];
 //echo "cmdt=".$cmdt."<br>\n";
 //echo substr($newdir,strlen($newdir)-2,2) . "===\n";
 if(substr($newdir,strlen($newdir)-2,2) == "..") {           // Переход на папку уровнем выше
 	$nn1=strrpos($newdir, "/",0);
 	$newdir=substr($newdir,0,$nn1);
 	$nn1=strrpos($newdir, "/",0);
 	$newdir=substr($newdir,0,$nn1);
 }
 if(strlen($newdir)>0) {
 	if(substr($newdir,-1,1) != "/") {$newdir.="/";}
 }
 if($cmdt=="file_del") {
 	if(substr($newdir,-1,1) == "/") {$newdir=substr($newdir,0,-1);}
 	if(is_file($newdir)) {
 		echo "Удаление файла ".$newdir."<br>\n";
 		unlink($newdir);
 	} else {
 		echo "Файл ".$newdir." не найден для удаления<br>\n";
 	}
 	$newdir=strrev($newdir);
 	//echo " =len=".strlen($newdir)."===<br>\n";
 	//echo " =r=".$newdir."===<br>\n";
 	//echo " =strpos=".strpos($newdir, "/",1)."=1=<br>\n";
 	//$newdir=substr($newdir,strpos($newdir, "/",1),1+strlen($newdir)-strpos($newdir, "/",1))."<br>\n";
 	$newdir=substr($newdir,strpos($newdir, "/",1));
 	$newdir=strrev($newdir);
 	//echo " =2=".$newdir."===<br>\n";
 	//echo substr($newdir,1,strpos($newdir, "/",-1)."<br>\n";
 }
 if($cmdt=="create") {
 	if ($handle = opendir($newdir)) {
 	  echo "Уже есть папка ".$newdir."<br>\n";
 	  closedir($handle);
 	 } else {
        mkdir($newdir, 0777, true);
        echo "Создается папка ".$newdir."<br>\n";
    }
 }
  if(strlen($newdir)>0) {
 	$uploaddir=$newdir;
  } else {
 	$uploaddir = $firdir;
  }
 if (!empty($_FILES['userfile']) and strlen($_FILES['userfile']['name'][0])>0) {
   echo "Загрузка в папку ".$uploaddir;
   $nf=count($_FILES['userfile']['name']);
   echo " Всего файлов ".$nf."<br>\n";
   for($i=0;$i<$nf;$i++) {
   	echo ($i+1)." ".$_FILES['userfile']['name'][$i]."\n";
    $uploadfile = $uploaddir . basename($_FILES['userfile']['name'][$i]);
    if (move_uploaded_file($_FILES['userfile']['tmp_name'][$i], $uploadfile)) {
     echo " Загружено ".$_FILES['userfile']['size'][$i]." байт с кодом завершения ".$_FILES['userfile']['error'][$i]."<br>\n";
    } else {
     echo "Файл ".$_FILES['userfile']['name'][$i]." Ошибка загрузки! Код ошибки ".$_FILES['userfile']['error'][$i]."<br>\n";
    }
   }
 } // --------------------------------------------------------------------------------------------------------------------------
   echo '<form enctype="multipart/form-data" action="c1.php" method="post">'."\n";
   echo '<input type="hidden" name="MAX_FILE_SIZE" value="4999999999" />'."\n";
   echo '<input class="t1" type="text" name="dir1" size="75" value="'.$uploaddir.'" />'."\n";
   echo '<input class="t1" type="file" name="userfile[]" multiple value="Выбор" class="t1" />'."\n";
   echo '&nbsp &nbsp <input type="submit" class="t1" >'."\n";
   echo '&nbsp &nbsp <a class="t2" href=c1.php > &nbsp Очистить &nbsp </a>'."\n";
   echo '&nbsp &nbsp <select id="cmid" name="cmd1" class="t1" onChange="sel1(this.value)" >'."\n";
   echo '<option value="command">command</option>'."\n";
   echo '<option value="create">Создать папку</option>'."\n";
   echo '<option value="rename">Переименовать папку</option>'."\n";
   echo '<option value="delete">Удалить папку</option>'."\n";
   echo '<option value="file_del">Удалить файл</option>'."\n";
   echo '</select>'."\n";
   echo '</form>'."\n";
   //echo '<span class="t1">Папка : '.$newdir."</span><br>\n";
   if(is_dir($newdir)) {
     $arf=[];
     $ard=[];
     $if=-1;
     $id=-1;
     $vb=0;
   	 if ($handle = opendir($newdir)) {
   		while (false !== ($entry = readdir($handle))) {
   			if(filetype($newdir.$entry)=="dir") {
   			  if ($entry != ".") {
   				$id+=1;
   				$ard[$id]=$entry;
   			  }
   			} else {
   				$if+=1;
   				$arf[$if]=$entry;
   			}
   		}
   		closedir($handle);
   		sort($ard);
   		sort($arf);
   		echo '<table><tr><td colspan="6">'.$newdir.'</td></tr>';
   		foreach ($ard as &$i) {
   			echo '<tr><td><img src="../fold1.png" width="24" height="24" alt="fold"> <sup>';
   			if(is_readable($newdir.$i)) { echo "r"; } else { echo "-";}
   			if(is_writable($newdir.$i)) { echo "w"; }  else { echo "-";}
   			if(is_executable($newdir.$i)) { echo "x"; }  else { echo "-";}
   			echo ' </sup> </td><td onclick="cltd(this.innerHTML)" >'.$i."</td><td> </td><td> </td><td> </td></tr> </td></tr>\n";
   		}
   		foreach ($arf as &$i) {
   		    echo '<tr><td><sup>';
   			switch (substr($i,-3,3)) {
   				case "jpg" :
   				case "peg" :
   				case "bmp" :
   				case "gif" :
   				case "png" :
   				case "ico" :
   				 echo '<img src="../fjpg1.png" width="24" height="24" alt="jpg ">';
   				 break;
   				case "htm" :
   				case "tml" :
   				 echo '<img src="../fhtm1.png" width="24" height="24" alt="htm ">';
   				 break;
   				case "php" :
   				 echo '<img src="../fphp1.png" width="24" height="24" alt="php ">';
   				 break;
   				case "txt" :
   				 echo '<img src="../ftxt1.png" width="24" height="24" alt="txt ">';
   				 break;
   				default:
   				 echo '<img src="../file1.png" width="24" height="24" alt="file">';
   			}
   			if(is_readable($newdir.$i)) { echo " r"; } else { echo " -";}
   			if(is_writable($newdir.$i)) { echo "w"; }  else { echo "-";}
   			if(is_executable($newdir.$i)) { echo "x"; }  else { echo "-";}
   			//echo "</sup></td>\n<td>".'<span class="t1" onclick="alert(this.innerHTML);">'.$i."</span></td>\n";
   			echo "</sup></td>\n<td>".'<span class="t1" onclick="cltd(this.innerHTML)">'.$i."</span></td>\n";
   			echo '<td> &nbsp &nbsp &nbsp </td><td align="right">'.number_format(filesize($newdir.$i),0,'',',')." b </td>\n";
   			echo '<td> &nbsp &nbsp &nbsp </td><td> '.date ("d.m.Y H:i:s",filemtime($newdir.$i))." </td>\n";
   			echo "</tr>\n";
   			$vb=$vb+filesize($newdir.$i);
   		}
   		echo "</table>\n";
   		echo ' Папок: '.count($ard).' &nbsp &nbsp &nbsp  Файлов: '.count($arf).'&nbsp&nbsp&nbsp Всего: '.number_format($vb,0,'',',')
." байт<br>\n";
   	 }
   } else {
      if(strlen($newdir)>0) {
      	echo 'Такая папка не найдена'."\n";
      }
   	  
   	  
   }
?>   
 </body>
</html>
