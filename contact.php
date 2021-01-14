<?php

session_start();

include 'db.php';
include 'test-input.php';

// variabilele pentru erori si valori din formular
$numeErr = $prenumeErr = $emailErr = $telefonErr = $mesajContactErr = $captchaErr = "";
$nume = $prenume = $email = $telefon = $mesajContact = "";
$captcha;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$numeArr = verificare_string("Numele este necesar!", $_POST["contactNume"]);
	$numeErr = $numeArr[0];
	$nume = $numeArr[1];

	$sprenumeArr = verificare_string("Stația de sosire este necesară!", $_POST["contactPrenume"]);
	$prenumeErr = $sprenumeArr[0];
	$prenume = $statieSosireArr[1];

	$emailArr = verificare_email("Adresa de mail este necesară!", $_POST["contactEmail"]);
	$emailErr = $emailArr[0];
	$email = $emailArr[1];


	if (empty($_POST["contactTelefon"])) {
		$telefonErr = "* Numărul de telefon este necesar!";
	} else {
		$telefon = test_input($_POST["contactTelefon"]);
		// verific daca numarul de telefon este valid 
		if (!filter_var($telefon, FILTER_SANITIZE_NUMBER_INT)) {
			$telefonErr = "Numarul de telefon este invalid!";
		}

		if (!preg_match("/^[0-9\-\(\)\/\+\s]*$/", $telefon)) {
			$telefonErr = "Numarul de telefon este invalid!";
		}

		if (strlen((string)$telefon) > 20) {
			$telefonErr = "Numarul de telefon este prea lung!";
		}

		if (strlen((string)$telefon) < 5) {
			$telefonErr = "Numarul de telefon este prea scurt!";
		}
	}

	if (empty($_POST["contactText"])) {
		$mesajContactErr = "Nu ati introdus niciun mesaj!";
	} else {
		$mesajContact = test_input($_POST["contactText"]);
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

	if (isset($_POST['submit']) && empty($numeErr) && empty($prenumeErr) && empty($emailErr) && empty($telefonErr) && empty($mesajContactErr) && $responseKeys["success"]) {
		$stmt = $conn->prepare("INSERT INTO formular_contact (nume, prenume, email, mesaj, nr_telefon) VALUES (?, ?, ?, ?, ?)");
		// s - string 
		$stmt->bind_param("sssss", $nume, $prenume, $email, $mesajContact, $telefon);

		if ($stmt->execute())
			header('Location: ?success');
		else
			header('Location: ?error');

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
		<section class="jumbotron text-center bg-img">
			<div class="container py-5 my-5 text-white">
				<h1>Pagina contact</h1>
				<p class="lead my-3">Dacă aveți nelămuriri sau reclamații lăsați-le mai jos. Vă mulțumim!</p>

				<?php if (isset($_GET['success']) || isset($_GET['error'])) : ?>
					<div class="alert my-5 <?= isset($_GET['success']) ? 'alert-success' : 'alert-danger' ?>" role="alert">
						<?php if (isset($_GET['success'])) echo 'Am trimis formularul cu succes.'; ?>
						<?php if (isset($_GET['error'])) echo 'Nu am putut trimite formularul.'; ?>
					</div>
				<?php endif; ?>

				<form name="contact-form" action="" method="post" id="formularContact">
					<div class="form-row">
						<div class="col-12 col-md-6 col-lg-6 col-xl-6 form-group text-left">
							<label for="contactNume">Nume*</label>
							<input type="text" class="form-control <?php if (isset($_POST['submit'])) : ?> <?= empty($numeErr) ? 'is-valid' : 'is-invalid' ?> <?php endif; ?>" name="contactNume" id="contactNume" placeholder="Popescu" value="<?= isset($_SESSION['nume']) ? $_SESSION['nume'] : $nume; ?>" required>
							<div class="invalid-feedback"><?= $numeErr; ?></div>
						</div>
						<div class="col-12 col-md-6 col-lg-6 col-xl-6 form-group text-left">
							<label for="contactPrenume">Prenume*</label>
							<input type="text" class="form-control <?php if (isset($_POST['submit'])) : ?> <?= empty($prenumeErr) ? 'is-valid' : 'is-invalid' ?> <?php endif; ?>" name="contactPrenume" id="contactPrenume" placeholder="Mihai" value="<?= isset($_SESSION['prenume']) ? $_SESSION['prenume'] : $prenume; ?>" required>
							<div class="invalid-feedback"><?= $prenumeErr; ?></div>
						</div>
						<div class="col-12 col-md-6 col-lg-6 col-xl-6 form-group text-left ">
							<label for="contactEmail">Adresă de email*</label>
							<input type="email" class="form-control <?php if (isset($_POST['submit'])) : ?> <?= empty($emailErr) ? 'is-valid' : 'is-invalid' ?> <?php endif; ?>" name="contactEmail" id="contactEmail" placeholder="mihai.popescu@mail.ro" value="<?= isset($_SESSION['email']) ? $_SESSION['email'] : $email; ?>" required>
							<div class="invalid-feedback"><?= $emailErr; ?></div>
						</div>
						<div class="col-12 col-md-6 col-lg-6 col-xl-6 form-group text-left ">
							<label for="contactTelefon">Număr de telefon*</label>
							<input type="tel" class="form-control <?php if (isset($_POST['submit'])) : ?> <?= empty($telefonErr) ? 'is-valid' : 'is-invalid' ?> <?php endif; ?>" name="contactTelefon" id="contactTelefon" placeholder="070 000 000" value="<?= $telefon; ?>" required>
							<div class="invalid-feedback"><?= $telefonErr; ?></div>
						</div>
						<div class="col-12 form-group text-left">
							<label for="contactText">Mesaj*</label>
							<textarea name="contactText" id="contactText" class="form-control <?php if (isset($_POST['submit'])) : ?> <?= empty($mesajContactErr) ? 'is-valid' : 'is-invalid' ?> <?php endif; ?>" rows="3" cols="28" rows="5" placeholder="Scrie aici." required><?= $mesajContact; ?></textarea>
							<div class="invalid-feedback"><?= $mesajContactErr; ?></div>
						</div>

						<div class="col-12 form-group text-center">
							<div class="g-recaptcha" data-sitekey=""></div>
							<p class="text-left"><?= $captchaErr; ?></p>
							<button type="submit" class="btn btn-primary" name="submit" value="Submit" id="submit_form">Trimite cererea</button>
						</div>

						<div class="col-12 form-group text-left">
							<p class="lead mt-3">Câmpurile marcate cu * sunt obligatorii!</p>
						</div>
					</div>

				</form>

			</div>
		</section>
		</div>

		<!-- FOOTER -->
		<?php include 'resurse/sectiuni/footer.php'; ?>
	</main>

</html>