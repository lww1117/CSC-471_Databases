<html>

  <!--Tab name and link to css. -->
  <head>
    <title>Add/Remove a Records!</title>
    <link rel = "stylesheet" href = "styleSheet.css">
  </head>

<body>

  <!--Page title. -->
  <header class = "records_head">
    <h1>Insert, Delete Records</h1>
  </header>

  <!--Contains code to add or remove TAKES records from the database -->
  <main class = "records_main">
    <?php
    //Enable showing error messages
    error_reporting(E_ALL, E_NOTICE);
    ini_set('display_errors', True);

    require 'connDB.php';

    #This takes the input from the dropboxes and places them in an array.
    if(isset($_POST['UUID'])){
      $data[0] = $_POST['UUID'];
    }

    if(isset($_POST['site_name'])){
      $data[1] = $_POST['site_name'];
    }

    if(isset($_POST['scientific_name'])){
      $data[2] = $_POST['scientific_name'];
    }

    #This will check if all the fields are set and then if the record already exists,
    #if there is no duplicate record and all the fields are set then the INSERT
    #will take place.
    if(isset($_POST['add'])){
      if(isset($data[0], $data[1], $data[2])){
        $check = $dbh->prepare("SELECT COUNT(*) FROM recieve WHERE UUID = ? AND
        site_name = ? AND scientific_name = ?;");
        $check->execute([$data[0], $data[1], $data[2]]);
        $checkSum = $check->fetchColumn();
        if($checkSum == 0){
          $recordInsert = $dbh->prepare("INSERT INTO recieve (UUID, site_name, scientific_name)
          VALUES (?, ?, ?);");
          $recordInsert->execute([$data[0], $data[1], $data[2]]);
          echo "Records added succesfully!</br>Ready for input.";
        }else{
          echo "Records already exist!</br>Ready for input.";
        }
      }else{
        echo "Please fill out all fields.";
      }
    }

    #This will check if all fields are set and if the record exists already. if
    #both are true then the remove statement will occur.
    if(isset($_POST['remove'])){
      if(isset($data[0], $data[1], $data[2])){
        $check = $dbh->prepare("SELECT COUNT(*) FROM recieve WHERE UUID = ? AND
        site_name = ? AND scientific_name = ?;");
        $check->execute([$data[0], $data[1], $data[2]]);
        $checkSum = $check->fetchColumn();
        if($checkSum == 1){
          $recordInsert = $dbh->prepare("DELETE FROM recieve WHERE UUID = ? AND
            site_name = ? AND scientific_name = ?;");
          $recordInsert->execute([$data[0], $data[1], $data[2]]);
          echo "Records removed succesfully!</br>Ready for input.";
        }else{
          echo "Records do not exist exist!</br>Ready for input.";
        }
      }else{
        echo "Please fill out all fields.";
      }
    }

    ?>

    <!--This will create the dropboxes filled with the appropriate options for
  the fields to be added or removed. -->
    <form action = "newRecords.php" method = "post">

      <div>
        <p>Patient UUID taking vaccine: </p>
        <select name="UUID">
         <?php
           $recordListStmt = $dbh->prepare("SELECT UUID FROM patients;");
           $recordListStmt->execute(); //execute the statement with no arguments (prepare statement has no ? attributes)
           $recordResults = $recordListStmt->fetchAll();
           for($idx = 0; $idx < count($recordResults); $idx++){
             $p = $recordResults[$idx];
             print("<option value=\"".$p['UUID']."\">".$p['UUID']."</option>");
           }
           ?>
        </select>
      </div>

      <div>
        <p>Vaccine site being used: </p>
        <select name="site_name">
         <?php
           $recordListStmt = $dbh->prepare("SELECT site_name FROM vaccine_site;");
           $recordListStmt->execute(); //execute the statement with no arguments (prepare statement has no ? attributes)
           $recordResults = $recordListStmt->fetchAll();
           for($idx = 0; $idx < count($recordResults); $idx++){
             $p = $recordResults[$idx];
             print("<option value=\"".$p['site_name']."\">".$p['site_name']."</option>");
           }
           ?>
        </select>
      </div>

      <div>
        <p>Vaccine being taken: </p>
        <select name="scientific_name">
         <?php
           $recordListStmt = $dbh->prepare("SELECT scientific_name FROM vaccine;");
           $recordListStmt->execute(); //execute the statement with no arguments (prepare statement has no ? attributes)
           $recordResults = $recordListStmt->fetchAll();
           for($idx = 0; $idx < count($recordResults); $idx++){
             $p = $recordResults[$idx];
             print("<option value=\"".$p['scientific_name']."\"> ".$p['scientific_name']."</option>");
           }
           ?>
        </select>
      </div>

      <input type = "submit" value = "Add" name = "add"/>
      <input type = "submit" value = "Remove" name = "remove"/>

    </form>
  </main>

  <!--Link to all sections and relevant subsections. -->
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
      <li><a href = "searchRecords.php">Search for a record.</a></li>
      <li><a href = "listRecords.php">Records list.</a></li>
    </div>

  </footer>

</body>
</html>
