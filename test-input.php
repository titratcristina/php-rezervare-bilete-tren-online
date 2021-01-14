<?php

function test_input($data)
{
    $data = trim($data); // eliminare spatii
    $data = strip_tags($data); // eliminare taguri HTML si PHP
    $data = stripslashes($data); // eliminare backslashes
    $data = htmlspecialchars($data); // transformare caractere html
    return $data;
}

function verificare_string($measjEroare, $postInput)
{
    $err = '';
    $string = '';

    if (empty($postInput)) {
        $err = $measjEroare;
    } else {
        $string = test_input($postInput);
        // verificare folosind regex daca textul introdus contine doar litere si spatii
        if (!preg_match("/^[a-zA-ZăâîșțĂÂÎȘȚ' -]*$/", $string)) {
            $err = "Sunt permise doar litere, linii și spații!";
        }
        // verificare lungime text
        if (strlen($string) < 3) {
            $err = "Ați introdus prea puține caractere.";
        }

        if (strlen($string) > 50) {
            $err = "Ați introdus prea multe caractere.";
        }
    }

    return array($err, $string);
}


function verificare_email($measjEroare, $postInput)
{
    $err = '';
    $email = '';

    if (empty($postInput)) {
        $err = $measjEroare;
    } else {
        $email = test_input($postInput);
        // verificare daca adresa de mail este validă
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $err = "Adresă de mail invalidă!";
        }
    }

    return array($err, $email);
}

function verificare_data($measjEroare, $postInput)
{
    $err = '';
    $data = '';

    if (empty($postInput)) {
        $err = $measjEroare;
    } else {
        $data = test_input($postInput);
        $esteData = date_create_from_format('Y-m-d', $data); // returneaza false daca nu reuseste sa formateze
        $dataCurenta = date("Y-m-d");

        if ($esteData) {
            $data = date_format($esteData, 'Y-m-d');
        }

        // verificare daca data nasterii este validă
        if ($esteData == FALSE || ($data > $dataCurenta) || ($data < "1950-01-01")) {
            $err = "Data nașterii invalidă!";
        }
    }

    return array($err, $data);
}

function verificare_plecare($measjEroare, $postInput)
{
    $err = '';
    $data = '';

    if (empty($postInput)) {
        $err = $measjEroare;
    } else {
        $data = test_input($postInput);
        $esteData = date_create_from_format('Y-m-d', $data); // returneaza false daca nu reuseste sa formateze
        $dataCurenta = date("Y-m-d");

        if ($esteData) {
            $data = date_format($esteData, 'Y-m-d');
        }

        $dataAnticipata = date("Y-m-d");
        $dataAnticipata = strtotime($dataAnticipata);
        $dataAnticipata = strtotime("+7 day", $dataAnticipata);

        // verificare daca data nasterii este validă
        if ($esteData == FALSE) {
            $err = "Data introdusă este invalidă!";
        }

        if ((strtotime($data) < strtotime($dataCurenta)) || (strtotime($data) > $dataAnticipata)) {
            $err = "Puteți căuta rute doar pentru următoarele 7 zile începând de azi.";
        }
    }

    return array($err, $data);
}
