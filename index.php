<?php
session_start();

if((isset($_SESSION['zalogowany']))) {
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

 <a href="rejestracja.php">Rejestracja</a>
 
 <form action="zaloguj.php" method="POST">
 <br>
 Login: <br> <input type="text" name="login" placeholder="Login" required /><br>
 Haslo: <br> <input type="password" name="haslo" placeholder="Hasło" required /><br><br>
 <input type="submit" value="Zaloguj sie"/>
 
 
 </form>
 <?php
 if(isset($_SESSION['udanaRejestracja'])){
	echo $_SESSION['udanaRejestracja'];
	unset($_SESSION['udanaRejestracja']);
 }


if(isset($_SESSION['blad'])) 

	echo $_SESSION['blad'];

?>


</body>



</html>