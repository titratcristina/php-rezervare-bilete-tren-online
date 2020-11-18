<?php
    session_start();
?>
<nav class="navbar navbar-expand-md navbar-light fixed-top bg-white">
    <a class="navbar-brand" href="index.php">Festina lente</a>
    <!-- <a class="navbar-brand" href="#">Vade mecum</a> -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link text-dark" href="index.php">Acasă</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Mersul trenurilor</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Anulări/Întârzieri</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="contact.php">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="detalii.php">Detalii</a>
            </li>
        </ul>

        <?php if(!isset($_SESSION['id'])): ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="inregistrare.php">Înregistrare</a>
                </li>
            </ul>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['id'])): ?>
            <ul class="navbar-nav ml-auto">
                <li>
                    <span class="navbar-text">Salut, <?= $_SESSION['prenume'] ?></span>
                </li>
                <?php if($_SESSION['tip_utilizator']=="admin"): ?>
                <li>
                    <a class="nav-link text-dark" href="admin.php">Admin</a>
                </li>
                <?php endif; ?>
                <li>
                    <a class="nav-link text-dark" href="autentificare.php?logout">Iesire</a>
                </li>
            </ul>
        <?php endif; ?>
    </div>
</nav>