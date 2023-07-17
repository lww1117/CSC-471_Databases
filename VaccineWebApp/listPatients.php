<!DOCTYPE html>
<html>

  <!-- Tab name and link to css.-->
  <head>
    <title>Patient List!</title>
    <link rel = "stylesheet" href = "styleSheet.css">
  </head>

  <body>

    <!-- Page title.-->
    <header class = "patient_head">
      <h1>List of Patients</h1>
    </header>

    <!-- Contains code for listing patients from database via dropdown menu.-->
    <main class = "patient_main">
      <?php

      error_reporting(E_ALL, E_NOTICE);
      ini_set('display_errors', True);

      require 'connDB.php';
      ?>
      <p>List of patients: </p>

      <!-- List code starts here.-->
      <form action="listPatients.php" method="post">

        <div>
        <select name="patientId">
        <?php
          $patientListStmt = $dbh->prepare("SELECT UUID, first_name, last_name FROM patients;");
          $patientListStmt->execute(); //execute the statement with no arguments (prepare statement has no ? attributes)
          $patientResults = $patientListStmt->fetchAll();
          for($idx = 0; $idx < count($patientResults); $idx++){
            $p = $patientResults[$idx];
            print("<option value=\"".$p['UUID']."\">".$p['UUID'].", ".$p['first_name'].", ".$p['last_name']."</option>");
          }
        ?>
        </select>

        </div>
      </form>
    </main>

    <!-- Links to all sections and relevant subsections.-->
    <footer class = "patient_footer">
      <div>
        <h2>Main Directory</h2>
        <li><a href = "index.php">Return to Main menu</a></li>
        <li><a href = "allergyPortal.php">Return to Allergy menu</a></li>
        <li><a href = "vaccinePortal.php">Return to Vaccine menu</a></li>
        <li><a href = "VaccineSitePortal.php">Return to Vaccine site portal</a></li>
        <li><a href = "recordsPortal.php">Return to records menu</a></li>
      </div>
      <div>
        <h2>Patient Directory</h2>
        <li><a href = "newPatients.php">Add a patient.</a></li>
        <li><a href = "patientSearch.php">Search or remove a patient.</a></li>
        <li><a href = "updatePatient.php">Update patients.</a></li>
      </div>

    </footer>



  </body>
</html>
