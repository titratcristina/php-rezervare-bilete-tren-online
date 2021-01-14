<?php
session_start();
include 'db.php';

if (isset($_POST['submit']) && !isset($_SESSION['id'])) {
	$stmt = $conn->prepare("SELECT * FROM utilizatori WHERE email = ? AND parola = MD5(?)");
	$stmt->bind_param("ss", $_POST['logareEmail'], $_POST['logareParola']);

	$stmt->execute();

	$user_details = $stmt->get_result();

	var_dump($stmt->num_rows);

	if ($user_details->num_rows == 1) {
		$user_data = $user_details->fetch_assoc();

		var_dump($user_data);

		$_SESSION['id'] = $user_data['id'];
		$_SESSION['nume'] = $user_data['nume'];
		$_SESSION['prenume'] = $user_data['prenume'];
		$_SESSION['email'] = $user_data['email'];
		$_SESSION['data_nasterii'] = $user_data['data_nasterii'];
		$_SESSION['tip_utilizator'] = $user_data['tip_utilizator'];

		if ($user_data['tip_utilizator'] == "admin") header('Location: admin.php');
		else header('Location: index.php');
	} else {
		header('Location: inregistrare.php?errorLogin');
	}

	//   if($stmt->execute()) 
	//     header('Location: ?success');
	//   else 
	//     header('Location: ?error');

	$stmt->close();
} else if (isset($_GET['logout'])) {
	session_unset();
	session_destroy();
	header('Location: index.php');
}
