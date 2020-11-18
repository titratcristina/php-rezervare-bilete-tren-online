<?php
    session_start();
    if(!isset($_SESSION['id'])||$_SESSION['tip_utilizator']!="admin") { header('location: inregistrare.php'); die(); }
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
        <h1>Pagina administrare</h1>

      </div>
    </section>

    <section class="container">
        <div class="row">
            <div class="col-12">
                <?php
                include 'db.php';

                $sql = "SELECT id, nume, prenume, email, mesaj, nr_telefon FROM formular_contact";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "id: " . $row["id"]. " - Name: " . $row["nume"]. " " . $row["prenume"]. "<br>";
                    }
                } else {
                    echo "0 results";
                }

                $conn->close();
                
                ?>
            </div>

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
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row"></th>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                               
                            </tbody>
                        </table>

                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- FOOTER -->
    <?php include 'resurse/sectiuni/footer.php';?>

  </main>
</html>