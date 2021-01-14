<?php
include 'db.php';
session_start();
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
                <h2>ANULĂRI</h2>
                <p class="lead mt-3">Mai jos găsiți informații despre anulări!</p>
            </div>
        </section>

        <div class="container py-5 mb-5">
            <div class="row">
                <div class="col-12">
                    <?php
                    $sql = "SELECT dt.id_tren, a.motiv_anulare, dt.data_plecare, t.statie_plecare, t.statie_sosire FROM anulare a JOIN detaliu_tren dt ON dt.id_detaliu = a.id_detaliu JOIN tren t ON dt.id_tren = t.id_tren";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='alert alert-danger' role='alert'>Trenul cu numărul " . $row["id_tren"] . " din data de " . $row["data_plecare"] . " ruta " . $row["statie_plecare"] . " - " . $row["statie_sosire"] . " a fost anulat. Cauză: " . $row["motiv_anulare"] . "</div>";
                        }
                    } else {
                        echo "Nu s-au găsit anulări. :D";
                    }
                    ?>
                </div>
            </div>
        </div>


        <!-- FOOTER -->
        <?php include 'resurse/sectiuni/footer.php'; ?>

    </main>

</html>