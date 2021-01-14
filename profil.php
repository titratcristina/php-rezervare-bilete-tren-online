<?php
include 'db.php';
include 'test-input.php';

session_start();
if (!isset($_SESSION['id']) || $_SESSION['tip_utilizator'] != "normal") {
    header('location: inregistrare.php');
    die();
}

// variabilele pentru erori si valori din formular
$numeErr = $prenumeErr = $emailErr = $dataNastereErr = $parolaReintrodusaErr = $parolaErr = "";
$nume = $prenume = $email = $dataNastere = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['schimbaParola'])) {
        if (empty($_POST["inregistrareParola"])) {
            $parolaErr = "Nu puteți face modificarea fără o parolă!";
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
            $parolaReintrodusaErr = "Nu puteți face modificarea fără a reintroduce parola!";
        } else {
            $parolaReintrodusa = test_input($_POST["confirmareParola"]);
            // verificare parola reintrodusa 
            if ($parolaReintrodusa !== $parola) {
                $parolaReintrodusaErr = "Parola reintrodusă nu se potrivește.";
            }
        }

        if (isset($_POST['submit']) && ($_POST['inregistrareParola'] == $_POST['confirmareParola']) && empty($parolaErr) && empty($parolaReintrodusaErr)) {
            $stmt = $conn->prepare("UPDATE utilizatori SET parola = MD5(?) WHERE id = ?");
            // s - string 
            $stmt->bind_param("si", $parola, $_SESSION['id']);

            if ($stmt->execute())
                header('Location: ?success=parola');
            else
                header('Location: ?errorModificare=parola');
        } else {
            header('Location: ?errorModificare=parola');
        }
    } else {
        $numeArr = verificare_string("Nu puteți face modificarea fără un nume introdus!", $_POST["modificareNume"]);
        $numeErr = $numeArr[0];
        $nume = $numeArr[1];

        $prenumeArr = verificare_string("Nu puteți face modificarea fără un prenume introdus!", $_POST["modificarePrenume"]);
        $prenumeErr = $prenumeArr[0];
        $prenume = $prenumeArr[1];

        $emailArr = verificare_email("Nu puteți face modificarea fără o adresă de mail!", $_POST["modificareEmail"]);
        $emailErr = $emailArr[0];
        $email = $emailArr[1];

        $dataNastereArr = verificare_data("Nu puteți face modificarea fără data nașterii!", $_POST["modificareDataNastere"]);
        $dataNastereErr = $dataNastereArr[0];
        $dataNastere = $dataNastereArr[1];

        if (isset($_POST['submit']) && empty($numeErr) && empty($prenumeErr) && empty($emailErr) && empty($dataNastereErr)) {
            $stmt = $conn->prepare("UPDATE utilizatori SET nume = ?, prenume = ?, email = ?, data_nasterii = ? WHERE id = ?");
            // s - string 
            // $stmt->bind_param("sssss", $_POST[''], $_POST['modificarePrenume'], $_POST['modificareEmail'], $_POST['modificareParola'], $_POST['modificareDataNastere']);
            $stmt->bind_param("ssssi", $nume, $prenume, $email, $dataNastere, $_SESSION['id']);

            if ($stmt->execute()) {
                $_SESSION['nume'] = $nume;
                $_SESSION['prenume'] = $prenume;
                $_SESSION['email'] = $email;
                $_SESSION['data_nasterii'] = $dataNastere;
                header('Location: ?success');
            } else
                header('Location: ?errorModificare');

            $stmt->close();
        }
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
        <section class="container mt-5 pt-5">
            <div class="row">
                <div class="col-3">
                    <img class="rounded-circle" src="resurse/img/default-user-image.png" alt="Default user image" width="200">
                </div>
                <div class="col-9">
                    <form action="" method="post" id="formular-inregistrare">
                        <?php if (isset($_GET['success']) || isset($_GET['errorModificare'])) : ?>
                            <div class="alert <?= isset($_GET['success']) ? 'alert-success' : 'alert-danger' ?>" role="alert">
                                <?php if (isset($_GET['success'])) {
                                    if ($_GET['success'] == 'parola')
                                        echo 'Parolă schimbată cu succes!';
                                    else echo 'Modificare realizată cu succes!';
                                } ?>

                                <?php if (isset($_GET['errorModificare'])) {
                                    if ($_GET['errorModificare'] == 'parola')
                                        echo 'Nu am putut schimba parola!' . $parolaErr . $parolaReintrodusaErr;
                                    else echo 'Modificare eșuată!';
                                } ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="modificareNume">Nume</label>
                                <input type="text" class="form-control <?php if (isset($_POST['submit'])) : ?> <?= empty($numeErr) ? '' : 'is-invalid' ?> <?php endif; ?>" name="modificareNume" id="modificareNume" placeholder='Popescu' value="<?= $nume ? $nume : $_SESSION['nume']; ?>">
                                <div class="invalid-feedback"><?= $numeErr; ?></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="modificarePrenume">Prenume</label>
                                <input type="text" class="form-control <?php if (isset($_POST['submit'])) : ?> <?= empty($prenumeErr) ? '' : 'is-invalid' ?> <?php endif; ?>" name="modificarePrenume" id="modificarePrenume" placeholder='Maria' value="<?= $prenume ? $prenume : $_SESSION['prenume']; ?>">
                                <div class="invalid-feedback"><?= $prenumeErr; ?></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="modificareEmail">Email</label>
                                <input type="email" class="form-control <?php if (isset($_POST['submit'])) : ?> <?= empty($emailErr) ? '' : 'is-invalid' ?> <?php endif; ?>" name="modificareEmail" id="modificareEmail" placeholder='maria.popescu@domeniu.ro' value="<?= $email ? $email : $_SESSION['email']; ?>">
                                <div class="invalid-feedback"><?= $emailErr; ?></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="modificareDataNastere">Data nasterii</label>
                                <input type="date" class="form-control <?php if (isset($_POST['submit'])) : ?> <?= empty($dataNastereErr) ? '' : 'is-invalid' ?> <?php endif; ?>" name="modificareDataNastere" id="modificareDataNastere" value="<?= $dataNastere ? $dataNastere : $_SESSION['data_nasterii']; ?>">
                                <div class="invalid-feedback"><?= $dataNastereErr; ?></div>
                            </div>
                        </div>
                        <div class="form-row mt-2">
                            <div class="col-6">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal">
                                    Schimbă parola
                                </button>
                            </div>
                            <div class="col-6 text-right">
                                <button type="submit" name="submit" class="btn btn-primary">Modifică</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-12 pt-5 mt-5">
                    <h2>Bilete cumpărate</h2>
                    <p>Mai jos găsiți lista cu biltele achiziționate pe site.</p>
                    <table class="table mt-5 pt-5">
                        <thead>
                            <tr>
                                <th scope="col">Numar bilet</th>
                                <th scope="col">Tren</th>
                                <th scope="col">Dată plecare</th>
                                <th scope="col">Stație plecare</th>
                                <th scope="col">Stație sosire</th>
                                <th scope="col">Oră plecare</th>
                                <th scope="col">Oră sosire</th>
                                <th scope="col">Loc</th>
                                <th scope="col">Preț</th>
                                <th scope="col">Factura</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT b.id_bilet, dt.data_plecare, dt.id_tren, t.statie_plecare, t.statie_sosire, t.ora_plecare, t.ora_sosire, dt.pret, b.loc, dt.anulat FROM bilet b JOIN detaliu_tren dt ON dt.id_detaliu = b.id_detaliu JOIN tren t ON dt.id_tren = t.id_tren WHERE id_utilizator = " . $_SESSION['id'];
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr><th scope='row'>" . $row["id_bilet"] . "</td><td>" . $row["id_tren"] .  "</td><td>"  . $row["data_plecare"] . "</td><td>" . $row["statie_plecare"] . "</td><td>" . $row["statie_sosire"] .  "</td><td>" . date('H:i', strtotime($row["ora_plecare"])) . "</td><td>" . date('H:i', strtotime($row["ora_sosire"])) . "</td><td>" . $row["loc"] . "</td><td>" .  $row["pret"] . "</td><td><a href='/bilet.php?id=" . $row["id_bilet"] . "' class='btn btn-primary' target='_blank'><img src='resurse/img/file.svg' alt='icon'></a></td></tr>";
                                }
                            } else {
                                echo "Nu s-au gasit bilete!";
                            }

                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-12 pt-5 mt-5">
                    <h2>Mesaje trimise</h2>
                    <p>Mai jos găsiți lista cu mesajele trimise către administrator.</p>
                    <table class="table mt-5 pt-5">
                        <thead>
                            <tr>
                                <th scope="col">ID tichet</th>
                                <th scope="col">Mesaj</th>
                                <th scope="col">Data</th>
                                <th scope="col">Rezolvat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT id, mesaj, data_trimiterii, rezolvat FROM formular_contact WHERE email = '" . $_SESSION['email'] . "'";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr><th scope='row'>" . $row["id"] . "</td><td>" . $row["mesaj"] .  "</td><td>"  . $row["data_trimiterii"] . "</td><td>" . $row["rezolvat"] = 1 ? 'Mesajul a fost rezolvat.' : 'Mesajul nu a fost încă rezolvat.' . "</td><td>";
                                }
                            } else {
                                echo "<tr><td>Nu s-au găsit tichete.</td></tr>";
                            }

                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Schimbă Parola</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form action="" method="post">
                            <div class="form-group">
                                <label for="inregistrareParola">Parolă</label>
                                <input type="password" class="form-control <?php if (isset($_POST['submit'])) : ?> <?= empty($parolaErr) ? '' : 'is-invalid' ?> <?php endif; ?>" name="inregistrareParola" id="inregistrareParola">
                            </div>
                            <div class="form-group">
                                <label for="confirmareParola">Reintroduceți parola</label>
                                <input type="password" class="form-control <?php if (isset($_POST['submit'])) : ?> <?= empty($parolaReintrodusaErr) ? '' : 'is-invalid' ?> <?php endif; ?>" name="confirmareParola" id="confirmareParola">
                            </div>
                            <input type="hidden" name="schimbaParola" value="true">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <?php include 'resurse/sectiuni/footer.php'; ?>

    </main>

</html>