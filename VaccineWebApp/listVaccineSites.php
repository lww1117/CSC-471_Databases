<!DOCTYPE html>
<html>

  <!-- Tab name and link to css.-->
  <head>
    <title>List of Vaccine Sites!</title>
    <link rel = "stylesheet" href = "styleSheet.css">
  </head>

  <body>

    <!-- Page title.-->
    <header class = "vaccine_site_header">
      <h1>Vaccine site List</h1>
    </header>

    <!-- Contains code to list all vaccine sites from the database via a dropdown box.-->
    <main class = "vaccine_site_main">
      <?php

      error_reporting(E_ALL, E_NOTICE);
      ini_set('display_errors', True);

      require 'connDB.php';
      ?>
      <p>List of vaccination sites: </p>

      <!-- Code for dropdown box begins here.-->
      <form action="listVaccineSites.php" method="post">

        <div>
        <select name="Vaccine_site">
         <?php
         echo "List of Vaccination sites: ";
           $patientListStmt = $dbh->prepare("SELECT site_name, site_street, site_city,
             site_state, site_zipcode FROM vaccine_site;");
           $patientListStmt->execute(); //execute the statement with no arguments (prepare statement has no ? attributes)
           $patientResults = $patientListStmt->fetchAll();
           for($idx = 0; $idx < count($patientResults); $idx++){
             $p = $patientResults[$idx];
             print("<option value=\"".$p['site_name']."\">".$p['site_name'].", ".
             $p['site_street'].", ".$p['site_city'].", ".$p['site_state'].", ".
             $p['site_zipcode']."</option>");
           }

        ?>
        </select>
        </div>

      </form>
    </main>

    <!-- Links to all sections and relevant subsections.-->
    <footer class = "vaccine_site_footer">
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
        <h2>Vaccine site Directory</h2>
        <li><a href = "newVaccineSite.php">Add, remove, or update a vaccine.</a></li>
        <li><a href = "searchVaccineSites.php">Search for a vaccine.</a></li>
      </div>

    </footer>

  </body>

</html>
