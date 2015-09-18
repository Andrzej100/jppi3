<?php
$przedmioty=array(array('gy','ty'));
?>
<html>
<form action="test3.php" method="POST">

<input type="checkbox" name="zaznaczone[][]" value='uigui'>

<input type="submit" value='wyslij'>
</html>
<?php
if($_POST['zaznaczone'][0]=='gy'){
	echo"jest dobrze";
	
}
var_dump($_POST);
?>