<?php
session_start();

if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true)) {
	header('Location: gra.php');
	exit();
}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	
	<title> Osadnicy - gra przegladarkowa</title>
</head>

<body>
 
 Tylko martwi ujrzeli koniec wojny- Platon <br><br>
 
 <form action="zaloguj.php" method="POST">
 
 Login: <br> <input type="text" name="login"/><br>
 Login: <br> <input type="text" name="logimn"/><br>
 Haslo: <br> <input type="password" name="haslo"/><br><br>
 <input type="submit" value="Zaloguj sie"/>
 
 
 </form>

<?php
if(isset($_SESSION['blad'])) 

	echo $_SESSION['blad'];

?>


</body>



</html>