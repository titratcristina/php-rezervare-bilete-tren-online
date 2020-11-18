<?php 

session_start();
if(isset($_SESSION['id'])||$_SESSION['tip_utilizator']=="normal") { header('location: index.php'); die(); }

include 'db.php';

if(isset($_POST['submit'])&&($_POST['inregistrareParola']==$_POST['confirmareParola'])){
  $stmt = $conn->prepare("INSERT INTO utilizatori (nume, prenume, email, parola, data_nasterii) VALUES (?, ?, ?, MD5(?), ?)");
  // s - string 
  $stmt->bind_param("sssss", $_POST['inregistrareNume'], $_POST['inregistrarePrenume'], $_POST['inregistrareEmail'], $_POST['inregistrareParola'], $_POST['inregistrareDataNastere']);

  if($stmt->execute()) 
    header('Location: ?success');
  else 
    header('Location: ?errorInreg');

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
    <div class="container py-5 my-5">
        <div class="row">
            <div class="col-12 col-md-6 col-xl-6 col-lg-6">
            <?php if(isset($_GET['success']) || isset($_GET['errorInreg'])): ?>
        <div class="alert <?= isset($_GET['success']) ? 'alert-success' : 'alert-danger' ?>" role="alert"> 
            <?php if(isset($_GET['success'])) echo 'Contul a fost creat :D'; ?>
            <?php if(isset($_GET['errorInreg'])) echo 'Nu am putut crea contul. :('; ?>
          </div>
      <?php endif; ?>
                <h2>Înregistrare</h2>
                <p>Pentru înregistrare completați datele de mai jos.</p>
                <form action="" method="post" id="formular-inregistrare">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inregistrareNume">Nume</label>
                            <input type="text" class="form-control" name="inregistrareNume" id="inregistrareNume" placeholder='Popescu' required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inregistrarePrenume">Prenume</label>
                            <input type="text" class="form-control" name="inregistrarePrenume" id="inregistrarePrenume" placeholder='Maria' required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inregistrareEmail">Email</label>
                            <input type="email" class="form-control" name="inregistrareEmail" id="inregistrareEmail" placeholder='adresa@domeniu.ro' required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inregistrareDataNastere">Data nasterii</label>
                            <input type="date" class="form-control" name="inregistrareDataNastere" id="inregistrareDataNastere" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inregistrareParola">Parolă</label>
                            <input type="password" class="form-control" name="inregistrareParola" id="inregistrareParola" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="confirmareParola">Reintroduceți parola</label>
                            <input type="password" class="form-control" oninput="verificaParola()" name="confirmareParola" id="confirmareParola" required>
                        </div>
                    </div>
                   
                    <button type="submit" name="submit" class="btn btn-primary">Înregistrare</button>
                </form>

            </div>

            <div class="col-1 d-none d-md-block d-lg-block d-xl-block"></div>
            <span class="border-left d-none d-md-block d-lg-block d-xl-block"></span>
            <div class="col-1 d-none d-md-block d-lg-block d-xl-block"></div>

            <div class="col-12 col-md-3 col-xl-3 col-lg-3 pt-5 pt-md-0 pt-lg-0 pt-xl-0">
            <?php if(isset($_GET['errorLogin'])): ?>
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
                    <p><a href="">Ai uitat parola?</a></p>
                    <button type="submit" name="submit" class="btn btn-primary">Autentificare</button>
                </form>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <?php include 'resurse/sectiuni/footer.php';?>

    <script language='javascript' type='text/javascript'>
    $('#formular-inregistrare').submit(function() {
        if(verificaParola()) return true;
        else return false;
    });

    function verificaParola() {
        input = document.getElementById("confirmareParola");
        if (input.value != document.getElementById('inregistrareParola').value) {
            input.setCustomValidity('Password Must be Matching.');
            return false;
        } else {
            input.setCustomValidity('');
            return true;
        }
    }
</script>

  </main>
</html>