<!DOCTYPE html>
<html>

  <!--Tab name and link to css. -->
  <head>
    <title>Search Records!</title>
    <link rel = "stylesheet" href = "styleSheet.css">
  </hear>

  <body>

    <!--Page title. -->
    <header class = "records_head">
      <h1>Record Search</h1>
    </header>

    <!--Contains code to  -->
    <main class = "records_main">
      <?php

      error_reporting(E_ALL, E_NOTICE);
      ini_set('display_errors', True);

      require 'connDB.php';
      ?>
      <form action="searchRecords.php" method="post">

        <div>
        <select name="recordId">
         <?php

         #Checks if the search button has been clicked and if the UUID being searched
         #has an entry in the recieve table. If it does the dropdown box will be
         #populated with the results.
          if(isset($_POST['search'])){
            $data[0] = $_POST['UUID'];
            $check = $dbh->prepare("SELECT COUNT(*) FROM recieve WHERE UUID = ?");
            $check->execute([$data[0]]);
            $checkSum = $check->fetchColumn();
            if($checkSum == 1){
              $recordListStmt = $dbh->prepare("SELECT UUID, site_name, scientific_name FROM recieve WHERE UUID = ?;");
              $recordListStmt->execute([$data[0]]); //execute the statement with no arguments (prepare statement has no ? attributes)
              $recordResults = $recordListStmt->fetchAll();
              for($idx = 0; $idx < count($recordResults); $idx++){
                $p = $recordResults[$idx];
                print("<option value=\"".$p['UUID']."\">".$p['UUID'].", ".$p['site_name'].
                ", ".$p['scientific_name']."</option>");
              }
            }else{
              echo "No records for this UUID.";
            }
          }

        ?>
      </select>
        </div>

        <!--This will grab the UUID number for the search function. -->
        <div>
          Search Records by UUID: <input type = "number" name = "UUID"
          required min = "1000">
        </div>

        <!--This creates the search button to trigger the method. -->
        <input type = "submit" value = "Search" name = "search"/>

      </form>
    </main>

    <!--Links to all sections and relevant subsections. -->
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
        <li><a href = "listRecords.php">Records list.</a></li>
      </div>

    </footer>
  </body>

</html>
