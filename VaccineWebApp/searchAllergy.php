<!DOCTYPE html>
<html>

  <!--Tab name and link to css. -->
  <head>
    <title>Search for Allergies!</title>
    <link rel = "stylesheet" href = "styleSheet.css">
  </head>

  <body>

    <!--Page title. -->
    <header class = "allergy_head">
      <h1 class = "allergy_title">Allergy Search</h1>
    </header>

    <!--Contains code to search for allergies by UUID -->
    <main class = "allergy_main">
      <?php

      error_reporting(E_ALL, E_NOTICE);
      ini_set('display_errors', True);

      require 'connDB.php';
      ?>
      <form action="searchAllergy.php" method="post">

        <!--This will create the dropbox for results. -->
        <div>
          <select name="patientId">
           <?php
            if(isset($_POST['search'])){
              $data[0] = $_POST['UUID'];
              $patientListStmt = $dbh->prepare("SELECT allergy FROM allergies WHERE UUID = ?;");
              $patientListStmt->execute([$data[0]]); //execute the statement with no arguments (prepare statement has no ? attributes)
              $patientResults = $patientListStmt->fetchAll();
              for($idx = 0; $idx < count($patientResults); $idx++){
                $p = $patientResults[$idx];
                print("<option value=\"".$p['allergy']."\">".$p['allergy']."</option>");
              }
            }
          ?>
          </select>
        </div>

        <!--This will create the text box to gather the UUID for searching. -->
        <div>
          Search patient allergies: <input type = "number" name = "UUID" required min ="1000">
        </div>
        <input type = "submit" value = "Search" name = "search"/>
      </form>
    </main>

    <!--Links to all sections and all relevant subsections. -->
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
        <li><a href = "newAllergies.php">Add or remove an allergy</a></li>
        <li><a href = "listAllergy.php">Allergy List</a></li>
      </div>

    </footer>
  </body>

</html>
