<?php

session_start();
if (isset($_SESSION['id']) || $_SESSION['tip_utilizator'] == "normal") {
	header('location: index.php');
	die();
}

include 'db.php';
include 'test-input.php';

// variabilele pentru erori si valori din formular
$numeErr = $prenumeErr = $emailErr = $dataNastereErr = $parolaErr = $parolaReintrodusaErr = "";
$nume = $prenume = $email = $dataNastere = $parola = $parolaReintrodusa = "";
$captcha;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$numeArr = verificare_string("Nu puteți finaliza înregistrarea fără un nume!", $_POST["inregistrareNume"]);
	$numeErr = $numeArr[0];
	$nume = $numeArr[1];

	$prenumeArr = verificare_string("Nu puteți finaliza înregistrarea fără un prenume!", $_POST["inregistrarePrenume"]);
	$prenumeErr = $prenumeArr[0];
	$prenume = $prenumeArr[1];

	$emailArr = verificare_email("Nu puteți finaliza înregistrarea fără o adresă de mail!", $_POST["inregistrareEmail"]);
	$emailErr = $emailArr[0];
	$email = $emailArr[1];

	$dataNastereArr = verificare_data("Nu puteți finaliza înregistrarea fără o adresă de mail!", $_POST["inregistrareDataNastere"]);
	$dataNastereErr = $dataNastereArr[0];
	$dataNastere = $dataNastereArr[1];

	if (empty($_POST["inregistrareParola"])) {
		$parolaErr = "Nu puteți finaliza înregistrarea fără o parolă!";
	} else {
		$parola = test_input($_POST["inregistrareParola"]);

		// verificare daca parola este sigura
		$uppercase = preg_match('@[A-Z]@', $parola);
		$lowercase = preg_match('@[a-z]@', $parola);
		$number    = preg_match('@[0-9]@', $parola);
		$specialChars = preg_match('@[^\w]@', $parola);

		if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
			$parolaErr = "Parola trebuie să fie de minim 8 caractere și să conțină cel puțin o literă mică, una mare, un număr și un caracter special (#$&!)";
		}
	}

	if (empty($_POST["confirmareParola"])) {
		$parolaReintrodusaErr = "Nu puteți finaliza înregistrarea fără a reintroduce parola!";
	} else {
		$parolaReintrodusa = test_input($_POST["confirmareParola"]);
		// verificare parola reintrodusa 
		if ($parolaReintrodusa !== $parola) {
			$parolaReintrodusaErr = "Parola reintrodusă nu se potrivește.";
		}
	}


	if (isset($_POST['g-recaptcha-response'])) {
		$captcha = $_POST['g-recaptcha-response'];
	}

	if (!$captcha) {
		$captchaErr = "Te rog să bifezi captcha!";
	}

	$secretKey = "";

	$ip = $_SERVER['REMOTE_ADDR'];

	// post request to server
	$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
	$response = file_get_contents($url);
	$responseKeys = json_decode($response, true);

	if (isset($_POST['submit']) && ($_POST['inregistrareParola'] == $_POST['confirmareParola']) && empty($numeErr) && empty($prenumeErr) && empty($emailErr) && empty($parolaErr) && empty($parolaReintrodusaErr) && empty($dataNastereErr) && $responseKeys["success"]) {
		$stmt = $conn->prepare("INSERT INTO utilizatori (nume, prenume, email, parola, data_nasterii) VALUES (?, ?, ?, MD5(?), ?)");
		// s - string 
		$stmt->bind_param("sssss", $nume, $prenume, $email, $parola, $dataNastere);

		if ($stmt->execute()) {
			$to      = $email;
			$subject = 'Bun venit pe site, ' . $prenume;
			$message = 'Ne bucuram sa te avem ca nou utilizator pe site, ' . $prenume . ' ' . $nume;
			$headers = array(
				'From' => 'noreply@titrat.ro',
				'Reply-To' => 'noreply@titrat.ro',
				'X-Mailer' => 'PHP'
			);

			mail($to, $subject, $message, $headers);
			header('Location: ?success');
		} else
			header('Location: ?errorInreg');

		$stmt->close();
	}
}


?>

<!doctype html>
<html>

<head>
	<?php include 'resurse/sectiuni/head.php'; ?>
</head>

<body>
	<header>
		<?php include 'resurse/sectiuni/meniu.php'; ?>
		<script src='https://www.google.com/recaptcha/api.js' async defer></script>
	</header>

	<main role="main">
		<div class="container py-5 my-5">
			<div class="row">
				<div class="col-12 col-md-6 col-xl-6 col-lg-6">
					<?php if (isset($_GET['success']) || isset($_GET['errorInreg'])) : ?>
						<div class="alert <?= isset($_GET['success']) ? 'alert-success' : 'alert-danger' ?>" role="alert">
							<?php if (isset($_GET['success'])) echo 'Contul a fost creat!'; ?>
							<?php if (isset($_GET['errorInreg'])) echo 'Înregistrare eșuată!'; ?>
						</div>
					<?php endif; ?>
					<h2>Înregistrare</h2>
					<p>Pentru înregistrare completați datele de mai jos.</p>
					<form action="" method="post" id="formular-inregistrare">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="inregistrareNume">Nume</label>
								<input type="text" class="form-control <?php if (isset($_POST['submit'])) : ?> <?= empty($numeErr) ? 'is-valid' : 'is-invalid' ?> <?php endif; ?>" name="inregistrareNume" id="inregistrareNume" placeholder='Popescu' value="<?= $nume; ?>">
								<div class="invalid-feedback"><?= $numeErr; ?></div>
							</div>
							<div class="form-group col-md-6">
								<label for="inregistrarePrenume">Prenume</label>
								<input type="text" class="form-control <?php if (isset($_POST['submit'])) : ?> <?= empty($prenumeErr) ? 'is-valid' : 'is-invalid' ?> <?php endif; ?>" name="inregistrarePrenume" id="inregistrarePrenume" placeholder='Maria' value="<?= $prenume; ?>">
								<div class="invalid-feedback"><?= $prenumeErr; ?></div>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="inregistrareEmail">Email</label>
								<input type="email" class="form-control <?php if (isset($_POST['submit'])) : ?> <?= empty($emailErr) ? 'is-valid' : 'is-invalid' ?> <?php endif; ?>" name="inregistrareEmail" id="inregistrareEmail" placeholder='maria.popescu@domeniu.ro' value="<?= $email; ?>">
								<div class="invalid-feedback"><?= $emailErr; ?></div>
							</div>
							<div class="form-group col-md-6">
								<label for="inregistrareDataNastere">Data nasterii</label>
								<input type="date" class="form-control <?php if (isset($_POST['submit'])) : ?> <?= empty($dataNastereErr) ? 'is-valid' : 'is-invalid' ?> <?php endif; ?>" name="inregistrareDataNastere" id="inregistrareDataNastere" value="<?= $dataNastere; ?>">
								<div class="invalid-feedback"><?= $dataNastereErr; ?></div>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="inregistrareParola">Parolă</label>
								<input type="password" class="form-control <?php if (isset($_POST['submit'])) : ?> <?= empty($parolaErr) ? '' : 'is-invalid' ?> <?php endif; ?>" name="inregistrareParola" id="inregistrareParola">
								<div class="invalid-feedback"><?= $parolaErr; ?></div>
							</div>
							<div class="form-group col-md-6">
								<label for="confirmareParola">Reintroduceți parola</label>
								<input type="password" class="form-control <?php if (isset($_POST['submit'])) : ?> <?= empty($parolaReintrodusaErr) ? '' : 'is-invalid' ?> <?php endif; ?>" name="confirmareParola" id="confirmareParola">
								<div class="invalid-feedback"><?= $parolaReintrodusaErr; ?></div>
							</div>
						</div>

						<div class="form-row">
							<div class="col-12 form-group">
								<div class="g-recaptcha" data-sitekey=""></div>
								<p class="text-left"><?= $captchaErr; ?></p>
								<button type="submit" name="submit" class="btn btn-primary">Înregistrare</button>
							</div>
						</div>

					</form>
					<p>Toate câmpurile sunt obligatorii!</p>

				</div>

				<div class="col-1 d-none d-md-block d-lg-block d-xl-block"></div>
				<span class="border-left d-none d-md-block d-lg-block d-xl-block"></span>
				<div class="col-1 d-none d-md-block d-lg-block d-xl-block"></div>

				<div class="col-12 col-md-3 col-xl-3 col-lg-3 pt-5 pt-md-0 pt-lg-0 pt-xl-0">
					<?php if (isset($_GET['errorLogin'])) : ?>
						<div class="alert alert-danger" role="alert">
							<?php echo 'Date de autentificare incorecte :('; ?>
						</div>
					<?php endif; ?>
					<h2>Autentificare</h2>
					<p>Pentru autentificare completați datele de mai jos.</p>
					<form action="autentificare.php" method="post" id="formular-autetificare">
						<div class="form-group">
							<label for="logareEmail">Adresă de Email</label>
							<input type="email" class="form-control" name="logareEmail" id="logareEmail" required>
						</div>
						<div class="form-group">
							<label for="logareParola">Parolă</label>
							<input type="password" class="form-control" name="logareParola" id="logareParola" required>
						</div>
						<button type="submit" name="submit" class="btn btn-primary">Autentificare</button>
					</form>
				</div>
			</div>
		</div>

		<!-- FOOTER -->
		<?php include 'resurse/sectiuni/footer.php'; ?>

	</main>

</html>
