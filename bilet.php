<?php
include 'db.php';
session_start();
if (!isset($_SESSION['id']) || $_SESSION['tip_utilizator'] != "normal") {
    header('location: inregistrare.php');
    die();
}

/*call the FPDF library*/
require('resurse/tfpdf/tfpdf.php');

function tiparireFactura($idUtilizator, $nume, $prenume, $dataCumparare, $idBilet, $idTren, $dataPlecare, $statiePlecare, $statieSosire, $oraPlecare, $oraSosire, $loc, $pret)
{
    /*A4 width : 219mm*/
    $pdf = new tFPDF('P', 'mm', 'A4');

    $pdf->AddPage();
    /*output the result*/

    /*set font to  Roboto, bold, 14pt*/
    $pdf->AddFont("Roboto", '', 'Roboto-Regular.ttf', true);
    $pdf->AddFont("Roboto", 'B', 'Roboto-Bold.ttf', true);
    $pdf->SetFont('Roboto', 'B', 20);

    /*Cell(width , height , text , border , end line , [align] )*/

    $pdf->Cell(189, 10, '', 0, 1);

    $pdf->Cell(59, 10, '', 0, 0);
    $pdf->Cell(71, 5, 'BILET DE CALATORIE', 0, 0);
    $pdf->Cell(59, 10, '', 0, 1);

    $pdf->Cell(189, 10, '', 0, 1);

    $pdf->SetFont('Roboto', 'B', 15);
    $pdf->Cell(71, 5, 'FESTINA LENTE S.R.L.', 0, 0);
    $pdf->Cell(59, 5, '', 0, 0);
    $pdf->Cell(59, 5, 'Detalii', 0, 1);

    $pdf->SetFont('Roboto', '', 10);

    $pdf->Cell(130, 5, 'Bucuresti, strada. Soseaua Pavel D. Kiseleff, sector 1', 0, 0);
    $pdf->Cell(25, 5, 'ID Utilizator:', 0, 0);
    $pdf->Cell(34, 5, $idUtilizator, 0, 1);

    $pdf->Cell(130, 5, 'Romania, 751001', 0, 0);
    $pdf->Cell(25, 5, 'Data:', 0, 0);
    $pdf->Cell(34, 5, $dataCumparare, 0, 1);

    $pdf->Cell(130, 5, '', 0, 0);
    $pdf->Cell(25, 5, 'Numar bilet:', 0, 0);
    $pdf->Cell(34, 5, $idBilet, 0, 1);


    $pdf->SetFont('Roboto', 'B', 15);
    $pdf->Cell(130, 5, 'Nume', 0, 0);
    $pdf->Cell(59, 5, '', 0, 0);
    $pdf->SetFont('Roboto', 'B', 10);
    $pdf->Cell(189, 10, '', 0, 1);

    $pdf->SetFont('Roboto', 'B', 15);
    $pdf->Cell(130, 5, $nume . ' ' . $prenume, 0, 1);

    $pdf->Cell(50, 10, '', 0, 1);

    $pdf->SetFont('Roboto', 'B', 10);
    /*Heading Of the table*/
    $pdf->Cell(10, 6, 'ID', 1, 0, 'C');
    $pdf->Cell(20, 6, 'ID Tren', 1, 0, 'C');
    $pdf->Cell(25, 6, 'Data plecare', 1, 0, 'C');
    $pdf->Cell(30, 6, 'Statie plecare', 1, 0, 'C');
    $pdf->Cell(30, 6, 'Statie sosire', 1, 0, 'C');
    $pdf->Cell(22, 6, 'Ora plecare', 1, 0, 'C');
    $pdf->Cell(22, 6, 'Ora sosire', 1, 0, 'C');
    $pdf->Cell(15, 6, 'Loc', 1, 0, 'C');
    $pdf->Cell(15, 6, 'Pret', 1, 1, 'C');/*end of line*/
    /*Heading Of the table end*/
    //189
    $pdf->SetFont('Roboto', '', 10);

    $pdf->Cell(10, 6, $idBilet, 1, 0);
    $pdf->Cell(20, 6, $idTren, 1, 0);
    $pdf->Cell(25, 6, $dataPlecare, 1, 0);
    $pdf->Cell(30, 6, $statiePlecare, 1, 0);
    $pdf->Cell(30, 6, $statieSosire, 1, 0);
    $pdf->Cell(22, 6, $oraPlecare, 1, 0);
    $pdf->Cell(22, 6, $oraSosire, 1, 0);
    $pdf->Cell(15, 6, $loc, 1, 0, 'R');
    $pdf->Cell(15, 6, $pret, 1, 1, 'R');

    $pdf->Output();
}

$stmt = $conn->prepare("SELECT b.id_bilet, b.data_cumparare, dt.data_plecare, dt.id_tren, t.statie_plecare, t.statie_sosire, t.ora_plecare, t.ora_sosire, dt.pret, b.loc, dt.anulat FROM bilet b JOIN detaliu_tren dt ON dt.id_detaliu = b.id_detaliu JOIN tren t ON dt.id_tren = t.id_tren WHERE id_bilet = ? AND id_utilizator = ?");
$stmt->bind_param("ii", $_GET['id'], $_SESSION['id']);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        tiparireFactura($_SESSION['id'], $_SESSION['nume'], $_SESSION['prenume'], date('d-m-Y', strtotime($row["data_cumparare"])), $row["id_bilet"], $row["id_tren"], $row["data_plecare"], $row["statie_plecare"], $row["statie_sosire"], date('H:i', strtotime($row["ora_plecare"])), date('H:i', strtotime($row["ora_sosire"])), $row["loc"],  $row["pret"]);
    } else {
        echo "<h1>Nu s-a găsit bilet!</h1>";
    }
}

$conn->close();
