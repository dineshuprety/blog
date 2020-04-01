<?php
	try{
	$pdo = new PDO('mysql:host=localhost;dbname=blog','root','');
//echo "connection successfull";
}catch(PDOException $f){

	echo $f->getmessage();

}
?>

