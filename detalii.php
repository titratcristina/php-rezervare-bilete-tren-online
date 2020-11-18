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
      <p class="lead mt-3">Site-ul își propune să faciliteze procesul de rezervare și cumpărare de bilete online.
          Rezervarea se face printr-un formular de pe prima pagină. Acesta va fi similar cu cel de mai jos:
          utilizatorul va fi nevoit să introducă stația de plecare, apoi de sosire, va aleage data plecării și numărul
          de pasageri, apoi se va face o cerere către baza de date prin care se returneză opțiuni de călătorie
          disponibile pe baza orarelor (mersul trenurilor).</p>
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

  <div class="container marketing mt-5 pt-5">
      <div class="row">
      <div class="col-12 text-center mb-5">
          <h2>Tipuri de utilizatori</h2>
      </div>
      <div class="col-lg-4">
          <svg width="5em" height="5em" viewBox="0 0 16 16" class="bi bi-emoji-neutral mb-4" fill="currentColor"
          xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
          <path fill-rule="evenodd" d="M4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5z" />
          <path
              d="M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z" />
          </svg>
          <h2>VIZITATOR</h2>
          <p>Utilizatorul de tip „vizitator” poate accesa pagini „publice”, precum <i>Mersul trenurilor</i> sau
          <i>Anulări</i>. Acesta poate căuta rute, dar nu poate achiziționa bilete (va fi redirecționat către pagina de
          înregistrare).</p>
      </div>
      <div class="col-lg-4">
          <svg width="5em" height="5em" viewBox="0 0 16 16" class="bi bi-emoji-smile mb-4" fill="currentColor"
          xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
          <path fill-rule="evenodd"
              d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683z" />
          <path
              d="M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z" />
          </svg>
          <h2>ÎNREGISTRAT</h2>
          <p>Utilizatorul care se înregistrează pe site, pe lângă planificarea călătoriei acesta poate cumpăra bilete
          sau poate anula o rezervare. Utilizatorul va avea o pagină dedicată, de unde își va putea administra contrul
          (schimbare mail/parola/adresă etc). De asemenea, va putea vedea istoricul achizițiilor făcute pe site.</p>
      </div>
      <div class="col-lg-4">
          <svg width="5em" height="5em" viewBox="0 0 16 16" class="bi bi-emoji-sunglasses mb-4" fill="currentColor"
          xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
          <path fill-rule="evenodd"
              d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM6.5 6.497V6.5h-1c0-.568.447-.947.862-1.154C6.807 5.123 7.387 5 8 5s1.193.123 1.638.346c.415.207.862.586.862 1.154h-1v-.003l-.003-.01a.213.213 0 0 0-.036-.053.86.86 0 0 0-.27-.194C8.91 6.1 8.49 6 8 6c-.491 0-.912.1-1.19.24a.86.86 0 0 0-.271.194.213.213 0 0 0-.036.054l-.003.01z" />
          <path
              d="M2.31 5.243A1 1 0 0 1 3.28 4H6a1 1 0 0 1 1 1v1a2 2 0 0 1-2 2h-.438a2 2 0 0 1-1.94-1.515L2.31 5.243zM9 5a1 1 0 0 1 1-1h2.72a1 1 0 0 1 .97 1.243l-.311 1.242A2 2 0 0 1 11.439 8H11a2 2 0 0 1-2-2V5z" />
          </svg>
          <h2>ADMINISTRATOR</h2>
          <p>Administratorul este cel care poate adăuga/modifica/elimina utilizatori din baza de date. Acesta
          va avea o mică pagină de administrare, de unde va putea face chiar rezervări în numele altor persoane sau
          anulări și poate vedea toate rezervările făcute. De asemenea, poate adăuga notificări pe site legate de
          întârzieri sau anulări.</p>
      </div>
      <div class="col-12 text-left mt-5">
          <h2 class="mb-5">Diagramă site</h2>
          <img class="img-fluid" src="/resurse/img/diagrama-site.svg" alt="diagrama-uml">
          <p class="mt-5">Paginile de pe site vor fi urmatoarele:</p>
          <ul>
          <li>Acasă</li>
          <ul>
              <li>Aceasta va fi pagina princilă de unde se vor introduce datele pentru rezervarea biletelor și va redirecționa către pagina dedicată rezervării.</li>
              <li>Va fi afișată ultima informație legată de întârzieri sau anulări din pagina dedicată sub forma unei alerte.</li>
          </ul>
          <li>Rezervare</li>
          <ul>
              <li>Pe această pagină se vor alege locurile și se va finaliza rezervarea dacă utilizatorul este înregistrat, altfel se face redirect către pagina de înregistrare.</li>
              <li>Selectarea locurilor se va face folosind imaginea svg de mai jos: <br>
              <img class="img-fluid my-3" src="/resurse/img/tren-interior.svg" alt="tren-interior">
              </li>
          </ul>
          <li>Mersul Trenurilor</li>
          <ul>
              <li>O pagină statică cu orarul trenurilor și rutele.</li>
          </ul>
          <li>Anulări/Întarzieri</li>
          <ul>
              <li>Pagină statică unde vor fi afișate întârzierile sau anulările scrise de administrator.</li>
          </ul>
          <li>Contact</li>
          <ul>
              <li>Pagină cu un formular de contact/reclamații.</li>
          </ul>
          <li>Logare/Înregistrare</li>
          <ul>
              <li>Pagină dedicată înregistrării sau logării.</li>
              <li>Va fi vizibilă doar utilizatoriilor neconectați care vizitează site-ul. </li>
              <li>Aceasta va conține un formular de înregistrare cu diverse câmpuri (Nume, Prenume, Email, Data nașterii, Parolă etc.) și de logare (Email, Parolă).</li>
              <li>Când un utilizator își face cont, acesta va primi un mail de bun venit.</li>
          </ul>
          <li>Cont utilizator</li>
          <ul>
              <li>Pagină dedicată administrării contului de utilizator.</li>
              <li>De aici utilizatorul își poatre schimba adresa de mail, parola etc.</li>
              <li>Utilizatorul va putea vedea și anula rezervările făcute.</li>
          </ul>
          <li>Administrare</li>
          <ul>
              <li>În pagina de administrare se pot vedea toate rezervările făcute și se pot modifica (șterge/adăugare).</li>
              <li>Administratorul poate adăuga informații legate de anulări sau întârzieri.</li>
              <li>Se pot modifica și utilizatorii (ștergere/modificare/adăugare).</li>
          </ul>
          </li>
      </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
      <div class="col-md-7">
          <h2 class="featurette-heading mt-3">Baza de date</span>
          </h2>
          <p class="lead">Baza de date va fi alcătuită din 3-4 tabele pentru:</p>
          <ul>
          <li>Utilizatori (va conține datele despre ei, inclusiv rolurile)</li>
          <li>Rezervări (date despre loc, zi, persoană etc.)</li>
          <li>Trenuri (număr locuri disponibile)</li>
          <li>Orar și Rute</li>
          </ul>
          <p><i>Diagrama bazei de date va fi actualizată după stabilirea tuturor tabelelor și relațiilor</i></p>
      </div>
      <div class="col-md-5">
          <img class="img-fluid" src="/resurse/img/diagrama-bd.svg" alt="diagrama-bd">
      </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
      <div class="col-md-5 order-md-2">
          <h2 class="featurette-heading mt-4">Inspirație</h2>
          <p class="lead">Link-uri de la platforme asemănătoare:</p>
          <ul>
          <li><a href="https://www.sj.se/en/home.html">SJ - Suedia</a></li>
          <li><a href="https://www.vy.no/en/">VY - Norvegia</a></li>
          <li><a href="https://www.vr.fi/en">VR - Finlanda</a></li>
          <li><a href="https://www.dsb.dk/en/">DSB - Danemarca</a></li>
          <li><a href="https://www.ns.nl/en">NS - Țările de Jos</a></li>
          <li><a href="https://www.bahn.com/en/view/index.shtml">DB - Germania</a></li>
          <li><a href="https://www.sncf.com/en">SNCF - Franta</a></li>
          <li><a href="https://www.trenitalia.com/en.html">Tren Italia</a></li>
          <li><a href="https://mersultrenurilor.infofer.ro/ro-RO/Itineraries">Infofer</a></li>

          </ul>
      </div>
      <div class="col-md-7 order-md-1">
          <img class="img-fluid" src="/resurse/img/inspo.png" alt="website">
      </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
      <div class="col-12">
          <h2 class="mb-4">Cerințe Tema 1</h2>
          <p>Realizati o pagina/pagini web in care prezentati aplicatia web aleasa ca proiect;</p>
          <p>Realizati o descriere a arhitecturii pentru aplicatia aleasa; (sugestie: identificati rolurile, entitatile
          si procesele specifice aplicatiei, precum si relatiile intre acestea; stabiliti componentele principale; o
          descriere succinta a bazei de date)</p>
          <p>Prezentati o descriere a solutiei de implementare propuse. (sugestie: puteti folosi UML pentru diverse
          specificari;)</p>

          <p>Sfaturi utile pentru implementarea proiectului:</p>
          <ul>
          <li>grupati elementele (sau functionalitatile) cu proprietati comune;</li>
          <li>decuplati cat mai mult posibil modulele voastre (incercati sa separati componentele care se ocupa de
              prezentare si cele de modelare);</li>
          <li>alegeti solutii de reutilizare a codului, evitati sa aveti doua sau mai multe componente care executa
              aceeasi operatie in contexte diferite;</li>
          <li>gasiti solutii de implementare generice care permit extinderi usoare ;</li>
          <li>puneti accent pe utilizare, propuneti fluxuri intuitive;</li>
          <li>inspirati-va din aplicatii web similare.</li>
          </ul>

          <p>Reguli generale de prezentare a temelor:</p>
          <li>incarcati codul sursa pe GitHub;</li>
          <li>gazduiti aplicatia web pe o solutie gratuita, astfel incat sa fie disponibila on-line;</li>
          <li>comunicati pana la termenul limita pe adresa de email vsl@fmi.unibuc.ro urmatoarele informatii: nume,
          grupa, url proiect github, url proiect gazduit;</li>
          <li>aplicatiile banale, fara functionalitati vor fi depunctate corespunzator;</li>
          <li>transmiterea cu intarziere a temelor va conduce la depunctarea acestora.</li>
      </div>

      <div class="col-12">
          <h2 class="mt-4">Tema 2: Proiectare implementare baza de date</h2>
          <p>Implementati functionalitatile de baza ale aplicatiei descrise la tema 1.</p>
          <p>Daca constatati ca planul de implementare descris in tema 1 necesita modificari, le puteti face.</p>
          <p>Aplicatia trebuie sa contina la acest nivel decat un mecanism simplu de autentificare si interactiuni de tip CRUD cu baza de date proiectata/implementata.</p>
          <p>Restul elementelor care tin de roluri si de securitatea aplicatiei vor fi implementate la tema 3.</p>

          <p>Sugestii pentru redactarea temei:</p>
          <ul>
          <li>gasiti o solutie pentru reutilizarea codului HTML in aplicatia voastra;</li>
          <li>folositi un mecanism generic de inserare/modificare/obtinere a informatiilor in/din BD;</li>
          <li>folositi un mecanism generic de parcurgere/afisare a elementelor aplicatiei;</li>
          <li>evitati sa folositi copy/paste pentru cod PHP; scrieti functii pentru astfel de situatii;</li>
          <li>folositi taguri <?php ?> pentru imbricarea codului PHP in codul HTML, evitati pe cat posibil afisarea unei pagini (sau a componentelor) HTML cu echo;</li>
          <li>gasiti o solutie pentru persistenta parametriilor (GET sau POST).</li>
          </ul>
          <p>Obs: mail-ul pe langa cerintele de la tema 1 va rog sa contina si datele de autentificare ale unui utilizator;</p>
      </div>
      </div>

      <hr class="featurette-divider">

    </div>

    <!-- FOOTER -->
    <?php include 'resurse/sectiuni/footer.php';?>

  </main>
</html>