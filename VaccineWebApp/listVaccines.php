<!DOCTYPE html>
<html>

  <!-- Tab name and css link.-->
  <head>
    <title>List of Vaccines!</title>
    <link rel = "stylesheet" href = "styleSheet.css">
  </head>

  <body>

    <!-- Page title.-->
    <header class = "vaccine_header">
      <h1>Vaccine List</h1>
    </header>

    <!-- Contains list of all available vaccines from database via a dropdown box.-->
    <main class = "vaccine_main">
      <?php

      error_reporting(E_ALL, E_NOTICE);
      ini_set('display_errors', True);

      require 'connDB.php';
      ?>
      <p>List of vaccines: </p>

      <!-- Code for dropdown box begins here.-->
      <form action="listVaccines.php" method="post">

        <div>
        <select name="Vaccine">
         <?php
           $patientListStmt = $dbh->prepare("SELECT scientific_name, disease FROM vaccine;");
           $patientListStmt->execute(); //execute the statement with no arguments (prepare statement has no ? attributes)
           $patientResults = $patientListStmt->fetchAll();
           for($idx = 0; $idx < count($patientResults); $idx++){
             $p = $patientResults[$idx];
             print("<option value=\"".$p['scientific_name']."\">".$p['scientific_name'].", ".$p['disease']."</option>");
           }

        ?>
        </select>
        </div>

      </form>
    </main>

    <!-- Links to all other sections and relevant subsections.-->
    <footer class = "vaccine_footer">
      <div>
        <h2>Main Directory</h2>
        <li><a href = "index.php">Return to Main menu</a></li>
        <li><a href = "patientPortal.php">Return to Patient menu</a></li>
        <li><a href = "allergyPortal.php">Return to Allergy menu</a></li>
        <li><a href = "vaccinePortal.php">Return to Vaccine menu</a></li>
        <li><a href = "VaccineSitePortal.php">Return to Vaccine site portal</a></li>
        <li><a href = "recordsPortal.php">Return to records menu</a></li>
      </div>
      <div>
        <h2>Vaccine Directory</h2>
        <li><a href = "newVaccine.php">Add, remove, or update a vaccine.</a></li>
        <li><a href = "searchVaccines.php">Search for a vaccine.</a></li>
      </div>

    </footer>

  </body>

</html>
