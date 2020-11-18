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
        <h1>Rezervare de bilete online pentru tren</h1>
        <p class="lead mt-3">Site-ul își propune să faciliteze procesul de rezervare și cumpărare de bilete online.</p>
        <p class="lead mt-3"><i>searching routes in development</i></p>

        <form class="mt-5 px-5 mx-5">
          <div class="form-row">
            <div class="col-6">
              <input type="text" class="form-control" placeholder="Stație de plecare">
            </div>
            <div class="col-6">
              <input type="text" class="form-control" placeholder="Stație de sosire">
            </div>
          </div>
          <div class="form-row mt-3">
            <div class="col-6">
              <input type="date" class="form-control">
            </div>
            <div class="col-6">
              <input type="number" class="form-control" placeholder="Număr călători">
            </div>
            <div class="col-12 mt-3">
              <button type="submit" class="btn btn-primary">Rezervare</button>
            </div>
          </div>
        </form>

      </div>
    </section>


    <!-- FOOTER -->
    <?php include 'resurse/sectiuni/footer.php';?>

  </main>
</html>