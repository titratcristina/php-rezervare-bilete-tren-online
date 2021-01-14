<?php
include 'db.php';
session_start();

if (!isset($_SESSION['id']) || $_SESSION['tip_utilizator'] != "admin") {
	header('location: inregistrare.php');
	die();
} else {
	if (isset($_GET['stergere-user'])) {
		$stmt = $conn->prepare("DELETE FROM utilizatori WHERE id = ? AND tip_utilizator != 'admin'");
		$stmt->bind_param("i", $_GET['id']);

		if ($stmt->execute())
			header('Location: ?succesStergereUser');
		else
			header('Location: ?eroareStergereUser');
	} else if (isset($_GET['mesaj-rezolvat'])) {
		$stmt = $conn->prepare("UPDATE formular_contact SET rezolvat = 1 WHERE id = ?");
		$stmt->bind_param("i", $_GET['id']);

		if ($stmt->execute())
			header('Location: ?succesRezolvare');
		else
			header('Location: ?eroareRezolvare');
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
				<h1>Pagina administrare</h1>

			</div>
		</section>

		<section class="container">
			<div class="row">

				<?php if (isset($_GET['succesStergereUser']) || isset($_GET['eroareStergereUser'])) : ?>
					<div class="alert <?= isset($_GET['succesStergereUser']) ? 'alert-success' : 'alert-danger' ?>" role="alert">
						<?php if (isset($_GET['succesStergereUser'])) echo 'Userul s-a șters cu succes. '; ?>
						<?php if (isset($_GET['eroareStergereUser'])) echo 'A aparut o eroare și nu s-a putut șterge userul.'; ?>
					</div>
				<?php endif; ?>

				<?php if (isset($_GET['succesRezolvare']) || isset($_GET['eroareRezolvare'])) : ?>
					<div class="alert <?= isset($_GET['succesRezolvare']) ? 'alert-success' : 'alert-danger' ?>" role="alert">
						<?php if (isset($_GET['succesRezolvare'])) echo 'Mesajul a fost marcat ca rezolvat.'; ?>
						<?php if (isset($_GET['eroareRezolvare'])) echo 'A aparut o eroare și nu s-a putut marca mesajul ca rezolvat.'; ?>
					</div>
				<?php endif; ?>

				<div class="col-12">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="utilizatori-tab" data-toggle="tab" href="#utilizatori" role="tab" aria-controls="utilizatori" aria-selected="true">Utilizatori</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Mesaje contact</a>
						</li>
					</ul>
					<div class="tab-content" id="tabelUtilizatori">
						<div class="tab-pane fade show active" id="utilizatori" role="tabpanel" aria-labelledby="utilizatori-tab">

							<table class="table">
								<thead>
									<tr>
										<th scope="col">id</th>
										<th scope="col">Nume</th>
										<th scope="col">Prenume</th>
										<th scope="col">Email</th>
										<th scope="col">Data Nasterii</th>
										<th scope="col">Tip Utilizator</th>
										<th scope="col">Data Înregistrării</th>
										<th scope="col">Actiuni</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sql = "SELECT id, nume, prenume, email, data_nasterii, tip_utilizator, data_inreg FROM utilizatori";
									$result = $conn->query($sql);

									if ($result->num_rows > 0) {
										while ($row = $result->fetch_assoc()) {
											if ($row["tip_utilizator"] == "admin") {
												echo "<tr><th scope='row'>" . $row["id"] . "</th><td>" . $row["nume"] . "</td><td>" . $row["prenume"] . "</td><td>" . $row["email"] . "</td><td>" . $row["data_nasterii"] . "</td><td>" . $row["tip_utilizator"] . "</td><td>" .  $row["data_inreg"] . "</td><td></td></tr>";
											} else {
												echo "<tr><th scope='row'>" . $row["id"] . "</th><td>" . $row["nume"] . "</td><td>" . $row["prenume"] . "</td><td>" . $row["email"] . "</td><td>" . $row["data_nasterii"] . "</td><td>" . $row["tip_utilizator"] . "</td><td>" .  $row["data_inreg"] . "</td><td><button class='btn btn-danger' data-href='?stergere-user&id=" . $row['id'] . "' data-toggle='modal' data-target='#confimare-stergere'><svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-person-dash-fill' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm5-.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z'/></svg></button></td><td></td></tr>";
											}
										}
									} else {
										echo "Nu s-au găsit rute...";
									}
									?>
								</tbody>
							</table>

						</div>
						<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
							<table class="table">
								<thead>
									<tr>
										<th scope="col">id</th>
										<th scope="col">Nume</th>
										<th scope="col">Prenume</th>
										<th scope="col">Email</th>
										<th scope="col">Mesaj</th>
										<th scope="col">Telefon</th>
										<th scope="col">Actiuni</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sql = "SELECT id, nume, prenume, email, mesaj, nr_telefon FROM formular_contact WHERE rezolvat = 0";
									$result = $conn->query($sql);

									if ($result->num_rows > 0) {
										while ($row = $result->fetch_assoc()) {
											echo "<tr><th scope='row'>" . $row["id"] . "</th><td>" . $row["nume"] . "</td><td>" . $row["prenume"] . "</td><td>" . $row["email"] . "</td><td>" . $row["mesaj"] . "</td><td>" . $row["nr_telefon"] . "</td><td><a href='?mesaj-rezolvat&id=" . $row['id'] . "' class='btn btn-success'>Rezolvat</a></td></tr>";
										}
									} else {
										echo "Nu s-au gasit mesaje!";
									}

									$conn->close();

									?>
								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>
		</section>

		<!-- Modal confirmare steregere user -->
		<div class="modal fade" id="confimare-stergere" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Sunteți sigur că vreți să ștergeți acest user?
					</div>
					<div class="modal-body">
						Modificarea nu se poate anula, veți șterge definitiv userul din baza de date.
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Anulează</button>
						<a class="btn btn-danger btn-ok">Șterege</a>
					</div>
				</div>
			</div>
		</div>

		<!-- FOOTER -->
		<?php include 'resurse/sectiuni/footer.php'; ?>

		<script>
			$('#confimare-stergere').on('show.bs.modal', function(e) {
				$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
			});
		</script>

	</main>

</html>