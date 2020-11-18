<?php 

include 'db.php';

if(isset($_POST['submit'])){
  $stmt = $conn->prepare("INSERT INTO formular_contact (nume, prenume, email, mesaj, nr_telefon) VALUES (?, ?, ?, ?, ?)");
  // s - string 
  $stmt->bind_param("sssss", $_POST['contactNume'], $_POST['contactPrenume'], $_POST['contactEmail'], $_POST['contactText'], $_POST['contactTelefon']);

  if($stmt->execute()) 
    header('Location: ?success');
  else 
    header('Location: ?error');

  $stmt->close();
} 

?>

<!doctype html>
<html>

<head>
  <?php include 'resurse/sectiuni/head.php';?>
</head>

<body>
  <header>
    <?php include 'resurse/sectiuni/meniu.php';?>
  </header>

  <main role="main">
    <section class="jumbotron text-center bg-img">
      <div class="container py-5 my-5 text-white">
        <h1>Pagina contact</h1>
        <p class="lead mt-3">Dacă aveți nelămuriri sau reclamații lăsați-le mai jos. Vă mulțumim!</p>
        <form name="contact-form" action="" method="post" id="formularContact">
          <div class="form-row">
            <div class="col-12 col-md-6 col-lg-6 col-xl-6 form-group text-left">
              <label for="contactNume">Nume</label>
              <input type="text" class="form-control" name="contactNume" id="contactNume" placeholder="Popescu" required>
            </div>
            <div class="col-12 col-md-6 col-lg-6 col-xl-6 form-group text-left">
              <label for="contactPrenume">Prenume</label>
              <input type="text" class="form-control" name="contactPrenume" id="contactPrenume" placeholder="Mihai" required>
            </div>
            <div class="col-12 col-md-6 col-lg-6 col-xl-6 form-group text-left ">
              <label for="contactEmail">Adresă de email</label>
              <input type="email" class="form-control" name="contactEmail" id="contactEmail" placeholder="Email" required>
            </div>
            <div class="col-12 col-md-6 col-lg-6 col-xl-6 form-group text-left ">
              <label for="contactTelefon">Număr de telefon</label>
              <input type="tel" class="form-control" name="contactTelefon" id="contactTelefon" placeholder="+4070 000 000" required>
            </div>
            <div class="col-12 form-group text-left">
              <label for="contactText">Text:</label>
              <textarea name="contactText" id="contactText" class="form-control" rows="3" cols="28" rows="5" placeholder="Scrie aici."></textarea>
            </div>

            <div class="col-12 form-group text-center">
              <button type="submit" class="btn btn-primary" name="submit" value="Submit" id="submit_form">Trimite cererea</button>
            </div>
          </div>

        </form>

      <?php if(isset($_GET['success']) || isset($_GET['error'])): ?>
        <div class="alert <?= isset($_GET['success']) ? 'alert-success' : 'alert-danger' ?>" role="alert"> 
            <?php if(isset($_GET['success'])) echo 'Am trimis formularul :D'; ?>
            <?php if(isset($_GET['error'])) echo 'Nu am putut trimite formularul. :('; ?>
          </div>
      <?php endif; ?>

      </div>
    </section>
    </div><!-- /.container -->


    <!-- FOOTER -->
    <?php include 'resurse/sectiuni/footer.php';?>
  </main>
</html>
