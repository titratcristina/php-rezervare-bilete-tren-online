<?php
include 'db.php';
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
                <h2>Tabel mersul trenurilor</h2>
                <p class="lead mt-3">Mai jos găsiți informații despre rutele pe care operăm!</p>
            </div>
        </section>

        <div class="container py-5 mb-5">
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Număr tren</th>
                                <th scope="col">Stație plecare</th>
                                <th scope="col">Stație sosire</th>
                                <th scope="col">Oră plecare</th>
                                <th scope="col">Oră sosire</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT id_tren, statie_plecare, statie_sosire, ora_plecare, ora_sosire FROM tren";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr><th scope='row'>" . $row["id_tren"] . "</th><td>" . $row["statie_plecare"] . "</td><td>" . $row["statie_sosire"] . "</td><td>" . date('H:i', strtotime($row["ora_plecare"])) . "</td><td>" . date('H:i', strtotime($row["ora_sosire"])) . "</td></tr>";
                                }
                            } else {
                                echo "Nu s-au găsit rute...";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- FOOTER -->
        <?php include 'resurse/sectiuni/footer.php'; ?>

    </main>

</html>