<?php
include 'db.php';
include 'test-input.php';

session_start();

function verificaLoc($locuri_totale)
{
    global $conn;
    // verificare daca exista locul alocat random
    $loc = rand(1, $locuri_totale);

    $stmt_loc = $conn->prepare("SELECT loc FROM bilet WHERE loc = ?");
    $stmt_loc->bind_param("i", $loc);

    if ($stmt_loc->execute()) {
        $stmt_loc->store_result();
        if ($stmt_loc->num_rows == 1) {
            verificaLoc($locuri_totale);
        } else {
            return $loc;
        }
    } else
        header('Location: ?eroareCumparare');

    $stmt_loc->close();
}

if (!isset($_SESSION['id'])) {
    header('location: inregistrare.php');
    die();
} else {
    if (isset($_GET['id_detaliu']) && !isset($_GET['succesCumparare']) && !isset($_GET['eroareCumparare'])) {
        $stmt = $conn->prepare("SELECT id_detaliu, locuri_totale FROM detaliu_tren WHERE id_detaliu = ?");
        $stmt->bind_param("i", $_GET['id_detaliu']);

        $locuri_totale = 100;

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            // verificare locuri totale pentru a aloca un numar random
            if ($stmt->num_rows == 1) {
                $data = $result->fetch_assoc();
                $locuri_totale = $data["locuri_totale"];
            }
        } else
            header('Location: ?eroareCumparare');

        $stmt->close();

        // verificare daca userul exista in tabelul cu bilete (acesta poate cumpara doar un bilet)
        $stmt_user = $conn->prepare("SELECT id_utilizator FROM bilet WHERE id_utilizator = ? AND id_detaliu = ?");
        $stmt_user->bind_param("ii", $_SESSION['id'], $_GET['id_detaliu']);

        $a_mai_cumparat = false;

        if ($stmt_user->execute()) {
            $stmt_user->store_result();

            if ($stmt_user->num_rows > 0) {
                $a_mai_cumparat = true;
            }
        } else
            header('Location: ?eroareCumparare');

        $stmt_user->close();

        $loc = verificaLoc($locuri_totale);

        if ($a_mai_cumparat == false) {

            $stmt_cumparare = $conn->prepare("INSERT INTO bilet(id_utilizator, id_detaliu, loc) VALUES (?, ?, ?)");
            $stmt_cumparare->bind_param("iii", $_SESSION['id'], $_GET['id_detaliu'], $loc);

            if ($stmt_cumparare->execute()) {
                header('Location: ?succesCumparare');
            }
        } else {
            header('Location: ?eroareCumparare');
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
        <div class="container py-5 mb-5">
            <div class="row mb-5 pb-5">
                <div class="col-12 mt-5 mb-5">
                    <?php if (isset($_GET['succesCumparare']) || isset($_GET['eroareCumparare'])) : ?>
                        <h2>
                            <?php if (isset($_GET['succesCumparare'])) echo 'Ai cumpărat cu succes!'; ?>
                            <?php if (isset($_GET['eroareCumparare'])) echo 'A apărut o eroare la cumpărare.'; ?>
                        </h2>
                    <?php endif; ?>
                </div>
            </div>
        </div>


        <!-- FOOTER -->
        <?php include 'resurse/sectiuni/footer.php'; ?>

    </main>

</html>