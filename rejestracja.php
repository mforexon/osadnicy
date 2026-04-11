<?php
session_start();

if(isset($_POST['email'])) {
	$wszystkoOk = true;

	$nick = trim($_POST['nick'] ?? '');
	if(strlen($nick) < 3 || strlen($nick) > 20) {

		$wszystkoOk = false;
		$_SESSION['eNick'] = 'Nickname musi mieć od 3 do 20 znaków';
	}	
	if(ctype_alnum($nick) == false) {
		$wszystkoOk = false;
		$_SESSION['eNick'] = 'Nickname może zawierać tylko litery i cyfry';
	}
	$email = trim($_POST['email'] ?? '');
	if(empty($email)) {
		$wszystkoOk = false;
		$_SESSION['eEmail'] = 'E-mail nie może być pusty';
	}
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$wszystkoOk = false;
		$_SESSION['eEmail'] = 'Nieprawidłowy adres e-mail';
	}
	$haslo = trim($_POST['haslo'] ?? '');
	$haslo2 = trim($_POST['haslo2'] ?? '');
	if(strlen($haslo) < 8 || strlen($haslo) > 20) {
		$wszystkoOk = false;
		$_SESSION['eHaslo'] = 'Hasło musi mieć od 8 do 20 znaków';
	}
	if($haslo !== $haslo2) {
		$wszystkoOk = false;
		$_SESSION['eHaslo'] = 'Hasła nie pasują do siebie';
	}
	


	if(!isset($_POST['regulamin'])) {
		$wszystkoOk = false;
		$_SESSION['eRegulamin'] = 'Musisz zaakceptować regulamin';
	}

	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	try {
		
			$rezultat = $polaczenie->prepare("SELECT id FROM uzytkownicy WHERE email = ?");
			if(!$rezultat) throw new Exception($polaczenie->error);

			$rezultat->bind_param("s", $email);

			if(!$rezultat->execute()) {
				throw new Exception($rezultat->error);
			}

			$wynik = $rezultat->get_result();

			if($wynik->num_rows > 0) {
				$wszystkoOk = false;
				$_SESSION['eEmail'] = "Istnieje juz taki E-mail w bazie";

			}
			$wynik->free();
			$rezultat->close();

			$rezultat = $polaczenie->prepare("SELECT id FROM uzytkownicy WHERE user = ?");

			if(!$rezultat) throw new Exception($polaczenie->error);

			$rezultat->bind_param("s", $nick);

			if(!$rezultat->execute()) {
				throw new Exception($rezultat->error);
			}
			
			$wynik = $rezultat->get_result();

			if($wynik->num_rows > 0) {
				$wszystkoOk = false;
				$_SESSION['eNick'] = "Istnieje juz taki nick w bazie";
			}
			$wynik->free();
			$rezultat->close();

	if($wszystkoOk == true) {

		$hasloHash = password_hash($haslo, PASSWORD_DEFAULT);
				$drewno = 100;
				$kamien = 100;
				$zboze = 100;
				$dnipremium = 14;

			$rezultat = $polaczenie->prepare("INSERT INTO uzytkownicy (id, user, pass, email, drewno, kamien, zboze, dnipremium) 
			VALUES (null, ?, ?, ?, ?, ?, ?, ?)"); 
			if(!$rezultat) throw new Exception($polaczenie->error);
					$rezultat->bind_param("sssiiii", $nick, $hasloHash, $email, $drewno, $kamien, $zboze, $dnipremium);
					
			if($rezultat->execute()) {
					$_SESSION['udanaRejestracja'] = "Zarejestrowano użytkownika - <b> $nick </b>";
					header("Location:index.php");
					exit();
			} else {
					throw new Exception($polaczenie->error);
			}

				$rezultat->close();
			}
		
			$polaczenie->close();
		}

	
	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera!</span>';
		echo '<br> Informacja deweloperska:' .$e;

	}
	
}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	
	<title> Osadnicy - rejestracja</title>
	<style>
		.error {
			color: red;
			margin-bottom: 10px;
			margin-top: 10px;
		}
	</style>

</head>

	<body>
		<form method="POST">
			Nickname: <br> <input type="text" name="nick" placeholder="Nickname" required value="<?php echo $_POST['nick'] ?? ''; ?>" /><br>
			<?php
				if(isset($_SESSION['eNick'])) {
					echo '<div class="error">'.$_SESSION['eNick'].'</div>';
				unset($_SESSION['eNick']);
			}
			?>
			E-mail: <br> <input type="text" name="email" placeholder="E-mail" required value="<?php echo $_POST['email'] ?? ''; ?>"/><br>
			<?php
				if(isset($_SESSION['eEmail'])) {
					echo '<div class="error">'.$_SESSION['eEmail'].'</div>';
				unset($_SESSION['eEmail']);
			}
			?>
			Hasło: <br> <input type="password" name="haslo" placeholder="Hasło" required  /><br>
			<?php
				if(isset($_SESSION['eHaslo'])) {
					echo '<div class="error">'.$_SESSION['eHaslo'].'</div>';
				unset($_SESSION['eHaslo']);
			}
			?>
			Powtórz hasło: <br> <input type="password" name="haslo2" placeholder="Powtórz hasło" required /><br>
			<br><label><input type="checkbox" name="regulamin"/> Akceptuje regulamin</label><br>
			<?php
				if(isset($_SESSION['eRegulamin'])) {
					echo '<div class="error">'.$_SESSION['eRegulamin'].'</div>';
				unset($_SESSION['eRegulamin']);
			}
			?>
			<input type="submit" value="Załóż konto"/>
		</form>


	</body>

</html>