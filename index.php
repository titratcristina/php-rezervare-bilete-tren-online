<?php
include 'db.php';
include 'test-input.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$statiePlecareArr = verificare_string("Stația de plecare este necesară!", $_POST["statiePlecare"]);
	$statiePlecareErr = $statiePlecareArr[0];
	$statiePlecare = $statiePlecareArr[1];

	$statieSosireArr = verificare_string("Stația de sosire este necesară!", $_POST["statieSosire"]);
	$statieSosireErr = $statieSosireArr[0];
	$statieSosire = $statieSosireArr[1];

	$dataPlecareArr = verificare_plecare("Data plecării este necesară!", $_POST["dataPlecare"]);
	$dataPlecareErr = $dataPlecareArr[0];
	$dataPlecare = $dataPlecareArr[1];


	if (isset($_POST['submit']) && empty($statiePlecareErr) && empty($statieSosireErr) && empty($dataPlecareErr)) {
		header('Location: cauta-rute.php?plecare=' . $statiePlecare . '&sosire=' . $statieSosire . '&data=' . $dataPlecare);
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
	</header>

	<main role="main">
		<section class="jumbotron text-center bg-img">
			<div class="container py-5 my-5 text-white">
				<div class="row">
					<div class="col-12">
						<h1>Rezervare de bilete online pentru tren</h1>
						<p class="lead mt-3">Site-ul își propune să faciliteze procesul de rezervare și cumpărare de bilete online.</p>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-md-6 col-lg-6 col-xl-6">
						<form action="" method="post" name="formular-cautare" id="formularCautare" class="mt-4 px-5">
							<h5 class="text-left pb-2">Caută rute </h5>
							<div class="form-row">
								<div class="form-group col-12">
									<input type="text" class="form-control <?php if (isset($_POST['submit'])) : ?> <?= empty($statiePlecareErr) ? 'is-valid' : 'is-invalid' ?> <?php endif; ?>" name="statiePlecare" id="statiePlecare" placeholder='Stație de plecare' value="<?= $statiePlecare; ?>">
									<div class="invalid-feedback"><?= $statiePlecareErr; ?></div>
								</div>

								<div class="form-group col-12">
									<input type="text" class="form-control <?php if (isset($_POST['submit'])) : ?> <?= empty($statieSosireErr) ? 'is-valid' : 'is-invalid' ?> <?php endif; ?>" name="statieSosire" id="statieSosire" placeholder='Stație de sosire' value="<?= $statieSosire; ?>">
									<div class="invalid-feedback"><?= $statieSosireErr; ?></div>
								</div>

								<div class="form-group col-12">
									<input type="date" class="form-control <?php if (isset($_POST['submit'])) : ?> <?= empty($dataPlecareErr) ? 'is-valid' : 'is-invalid' ?> <?php endif; ?>" name="dataPlecare" id="dataPlecare" value="<?= $dataPlecare; ?>">
									<div class="invalid-feedback"><?= $dataPlecareErr; ?></div>
								</div>

								<div class="col-12 form-group">
									<button type="submit" name="submit" class="btn btn-primary mt-3">Rezervare</button>
								</div>
							</div>
						</form>
					</div>

					<div class="mt-4 px-5 col-12 col-md-6 col-lg-6 col-xl-6 text-left">
						<h5 class="text-white">Rutele noastre sunt:</h5> <br>
						<ul>
							<li>București - Constanța </li>
							<li>București - Brașov</li>
							<li>București - Buzău</li>
							<li>Cluj-Napoca - Oradea</li>
							<li>Oradea - Timișoara </li>
						</ul>
					</div>
				</div>

			</div>
		</section>

		<div class="container py-5 mb-5">
			<div class="row">
				<div class="col-12 col-md-6 col-lg-6 col-xl-6">
					<div class="card border-primary">
						<h5 class="card-header bg-primary border-primary text-white">Rute operate de Festina lente</h5>
						<div class="card-body">
							<p class="card-text">În prezent FESTINA LENTE SRL asigură transportul feroviar al călătorilor pe relațiile menționate mai jos.</p>
							<ul>
								<li>București - Constanța </li>
								<li>București - Brașov</li>
								<li>București - Buzău</li>
								<li>Cluj-Napoca - Oradea</li>
								<li>Oradea - Timișoara </li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6 col-lg-6 col-xl-6">
					<div class="card">
						<h5 class="card-header">Modalități de achiziționare a biletelor</h5>
						<div class="card-body">
							<h5 class="card-title">Online</h5>
							<p class="card-text">Urmăriți videoclipul de mai jos pentru mai multe detalii despre modul în care se pot cumpăra bilete folosind platforma.</p>
							<h5>Direct din tren</h5>
							<p>Se pot achiziționa bilete direct din tren la prețul standard (plată card sau numerar).</p>
						</div>
					</div>
				</div>
				<div class="col-12 mt-3">
					<video class="w-100" controls muted>
						<source src="resurse/img/video.mov" type="video/mp4">
					</video>
				</div>
			</div>
		</div>

		<!-- FOOTER -->
		<?php include 'resurse/sectiuni/footer.php'; ?>

	</main>

</html>