<!DOCTYPE html>
<html>

  <!-- Tab name and link to css.-->
  <head>
    <title>List of Vaccines!</title>
    <link rel = "stylesheet" href = "styleSheet.css">
  </head>
  <body>

    <!-- Page title.-->
    <header class = "records_head">
      <h1>Vaccine List</h1>
    </header>

    <!-- Contains code for listing all patient TAKES records from database via a
  dropdown box.-->
    <main class = "records_main">
      <?php

      error_reporting(E_ALL, E_NOTICE);
      ini_set('display_errors', True);

      require 'connDB.php';
      ?>
      <p>List of records: </p>

      <!-- Code for dropdown box starts here.-->
      <form action="listRecords.php" method="post">

        <div>
        <select name="Record">
         <?php
           $recordListStmt = $dbh->prepare("SELECT UUID, site_name, scientific_name FROM recieve;");
           $recordListStmt->execute(); //execute the statement with no arguments (prepare statement has no ? attributes)
           $recordResults = $recordListStmt->fetchAll();
           for($idx = 0; $idx < count($recordResults); $idx++){
             $p = $recordResults[$idx];
             print("<option value=\"".$p['UUID']."\">".$p['UUID'].", ".$p['site_name'].", ".$p['scientific_name']."</option>");
           }

        ?>
      </select>

        </div>
      </form>
    </main>

    <!-- Links to all sections and relevant subsections.-->
    <footer class = "records_footer">
      <div>
        <h2>Main Directory</h2>
        <li><a href = "index.php">Return to Main menu</a></li>
        <li><a href = "allergyPortal.php">Return to Allergy menu</a></li>
        <li><a href = "vaccinePortal.php">Return to Vaccine menu</a></li>
        <li><a href = "VaccineSitePortal.php">Return to Vaccine site portal</a></li>
        <li><a href = "recordsPortal.php">Return to records menu</a></li>
      </div>
      <div>
        <h2>Records Directory</h2>
        <li><a href = "newRecords.php">Add or remove a record.</a></li>
        <li><a href = "searchRecords.php">Search for a record.</a></li>
      </div>

    </footer>
  </body>

</html>
