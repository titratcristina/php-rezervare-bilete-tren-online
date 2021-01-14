<?php
include 'db.php';
include 'test-input.php';

function schimbare_statie($statie)
{
    if (preg_match('/\bBucu|\bbucu/', $statie)) {
        $statie = 'București';
    } else if (preg_match('/\bConst|\bconst/', $statie)) {
        $statie = 'Constanța';
    } else if (preg_match('/\bBra|\bbra/', $statie)) {
        $statie = 'Brașov';
    } else if (preg_match('/\bBuz|\bbuz/', $statie)) {
        $statie = 'Buzău';
    } else if (preg_match('/\bCluj|\bcluj/', $statie)) {
        $statie = 'Cluj-Napoca';
    } else if (preg_match('/\bOrad|\borad/', $statie)) {
        $statie = 'Oradea';
    } else if (preg_match('/\bTimi|\btimi/', $statie)) {
        $statie = 'Timișoara';
    }

    return $statie;
}

$get_bnr = simplexml_load_string(file_get_contents("https://www.bnr.ro/nbrfxrates.xml"));
$eur_val = floatval(json_decode(json_encode($get_bnr->Body->Cube->Rate[10]), true)[0]);

$statiePlecareArr = verificare_string("Stația de plecare este necesară!", $_GET["plecare"]);
$statiePlecareErr = $statiePlecareArr[0];
$statiePlecare = $statiePlecareArr[1];

$statieSosireArr = verificare_string("Stația de sosire este necesară!", $_GET["sosire"]);
$statieSosireErr = $statieSosireArr[0];
$statieSosire = $statieSosireArr[1];

$dataPlecareArr = verificare_plecare("Data plecării este necesară!", $_GET["data"]);
$dataPlecareErr = $dataPlecareArr[0];
$dataPlecare = $dataPlecareArr[1];

// București, Constanța, Brașov, Buzău, Cluj-Napoca, Oradea, Timișoara
$statiePlecare = schimbare_statie($statiePlecare);
$statieSosire = schimbare_statie($statieSosire);


if (empty($statiePlecareErr) && empty($statieSosireErr) && empty($dataPlecareErr)) {
    $stmt = $conn->prepare("SELECT dt.id_detaliu, dt.id_tren, dt.data_plecare, t.statie_plecare, t.statie_sosire, t.ora_plecare, t.ora_sosire, dt.pret FROM detaliu_tren dt JOIN tren t ON t.id_tren = dt.id_tren WHERE dt.anulat = 1 AND t.statie_plecare = ? AND t.statie_sosire = ? AND dt.data_plecare = ?;");
    $stmt->bind_param("sss", $statiePlecare, $statieSosire, $dataPlecare);
} else {
    header('Location: index.php');
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
        <div class="container py-5 mb-5">
            <div class="row mb-5">
                <div class="col-12 mb-3">
                    <h2>Rezultatele căutării</h2>

                    <p>Mai jos găsiți trenurile pentru ruta <?= $statieSosire ?> - <?= $statiePlecare ?></p>
                </div>
                <div class="col-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Număr tren</th>
                                <th scope="col">Stație plecare</th>
                                <th scope="col">Stație sosire</th>
                                <th scope="col">Oră plecare</th>
                                <th scope="col">Oră sosire</th>
                                <th scope="col">Preț</th>
                                <th scope="col">EUR</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($stmt->execute()) {
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $plecareOra = date('H:i', strtotime($row["ora_plecare"]));
                                        $sosireOra = date('H:i', strtotime($row["ora_sosire"]));

                                        if (!isset($_SESSION['id'])) {
                                            $cumpara = "<a href='/inregistrare.php'>Autentificare</a>";
                                        } else {
                                            $cumpara = "<a href='/cumpara.php?id_detaliu=" . $row["id_detaliu"] . "'>Cumpără</a>";
                                        }

                                        echo "<tr><th scope='row'>" . $row["id_tren"] . "</th><td>" . $row["statie_plecare"] . "</td><td>" . $row["statie_sosire"] . "</td><td>" . $plecareOra . "</td><td>" . $sosireOra . "</td><td>" . $row["pret"] . " lei</td><td>" . round($row["pret"] / $eur_val, 2) . " EUR</td><td>" . $cumpara . " </td></tr>";
                                    }
                                } else {
                                    echo "<tr><th scope='row'>Nu s-au găsit rute...</tr></th>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- FOOTER -->
            <?php include 'resurse/sectiuni/footer.php'; ?>

    </main>

</html>