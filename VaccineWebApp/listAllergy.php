<!DOCTYPE html>
<html>

  <!-- Tab name and css link-->
  <head>
    <title>List of Allergies!</title>
    <link rel = "stylesheet" href = "styleSheet.css">
  </head>

  <body>

    <!-- Page title-->
    <header class = "allergy_head">
      <h1 class = "allergy_title">Allergy List</h1>
    </header>

    <!-- Main section contains code for listing all the allergy entries in the database
  via a dropdown menu.-->
    <main class = "allergy_main">

      <?php
      error_reporting(E_ALL, E_NOTICE);
      ini_set('display_errors', True);

      require 'connDB.php';
      ?>
      <p>List of allergies: </p>

      <!-- This is the code for dropdown menu.-->
      <form action="listAllergy.php" method="post">
        <div>
        <select name="patientId">

         <?php
           $patientListStmt = $dbh->prepare("SELECT UUID, allergy FROM allergies;");
           $patientListStmt->execute(); //execute the statement with no arguments (prepare statement has no ? attributes)
           $patientResults = $patientListStmt->fetchAll();
           for($idx = 0; $idx < count($patientResults); $idx++){
             $p = $patientResults[$idx];
             print("<option value=\"".$p['UUID']."\">".$p['UUID'].", ".$p['allergy']."</option>");
           }
        ?>

        </select>
        </div>
      </form>
    </main>

    <!-- Links to all other relevant sections and subsections.-->
    <footer class = "allergy_footer">
      <div>
        <h2>Main Directory</h2>
        <li><a href = "index.php">Return to Main menu</a></li>
        <li><a href = "patientPortal.php">Return to Patient menu</a></li>
        <li><a href = "vaccinePortal.php">Return to Vaccine menu</a></li>
        <li><a href = "VaccineSitePortal.php">Return to Vaccine site portal</a></li>
        <li><a href = "recordsPortal.php">Return to records menu</a></li>
      </div>
      <div>
        <h2>Allergy Directory</h2>
        <li><a href = "searchAllergy.php">Search Allergies</a></li>
        <li><a href = "newAllergies.php">Add or remove an allergy</a></li>
      </div>

    </footer>

  </body>

</html>
