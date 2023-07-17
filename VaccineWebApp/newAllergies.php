<html>

  <!- Tab name and link to css.-->
  <head>
    <title>Add/Remove an Allergy!</title>
    <link rel = "stylesheet" href = "styleSheet.css">
  </head>

  <body>

    <!- Page title.-->
    <header class = "allergy_head">
      <h1 class = "allergy_title">Insert or Delete an Allergy</h1>
    </header>

    <!- Conatins code to add or remove an allergy from the database.-->
    <main class = "allergy_main">
      <?php
      //Enable showing error messages
      error_reporting(E_ALL, E_NOTICE);
      ini_set('display_errors', True);

      //Connect to the database. Instantiates $dbh PDO
      require 'connDB.php';


      #Checks if the submit button has been clicked. It will then assign the
      #patient id and allergy to an array and use those values for an insert query.
      if(isset($_POST['submit'])){
        if(!empty($_POST['allergy'])){
          $newAllergy[0] = $_POST['patientId'];
          $newAllergy[1] = $_POST['allergy'];
          $check = $dbh->prepare("SELECT COUNT(*) FROM allergies WHERE UUID = ? AND allergy = ?");
          $check->execute([$newAllergy[0], $newAllergy[1]]);
          $checkSum = $check->fetchColumn();
          if ($checkSum == 0){
            $insertAllergy = $dbh->prepare("INSERT INTO allergies (UUID, allergy) VALUES (?, ?);");
            $insertAllergy->execute([$newAllergy[0], $newAllergy[1]]);
            echo 'Allergy inserted succesfully.</br>';
          }else if ($check != 0){
            echo 'Allergy already registered. </br>';
          }
        echo 'Ready for input.';
        }
      }


      #Checks if the remove button has been clicked. It will assign the two values
      #to an array and use them for a delete query.
      if(isset($_POST['remove'])){
        $newAllergy[0] = $_POST['patientId'];
        $newAllergy[1] = $_POST['allergy'];
        $check = $dbh->prepare("SELECT COUNT(*) FROM allergies WHERE UUID = ? AND allergy = ?");
        $check->execute([$newAllergy[0], $newAllergy[1]]);
        $checkSum = $check->fetchColumn();
        if ($checkSum == 0){
          echo 'Allergy not found.</br>';
        }else if ($check != 0){
          $deleteAllergy = $dbh->prepare("DELETE FROM allergies WHERE UUID = ? AND allergy = ?");
          $deleteAllergy->execute([$newAllergy[0], $newAllergy[1]]);
          echo 'Allergy succesfully removed. </br>';
        }
      echo 'Ready for input.';
      }

      ?>

      <!--This will populate a list of partients from the database. -->
      <form action="newAllergies.php" method="post">
       <div>
       Patient:
       <select name="patientId">
        <?php //PHP will populate the contents of the select menu
          $patientListStmt = $dbh->prepare("SELECT UUID, first_name, last_name FROM patients;");
          $patientListStmt->execute(); //execute the statement with no arguments (prepare statement has no ? attributes)
          $patientResults = $patientListStmt->fetchAll();
          for($idx = 0; $idx < count($patientResults); $idx++){
            $p = $patientResults[$idx];
            print("<option value=\"".$p['UUID']."\">".$p['UUID']."(".$p['first_name']." ".$p['last_name'].")</option>");
          }
        ?>
       </select>
       </div>

       <!--This will create a text box to enter allergies into. -->
       <div>
       Allergy:<input type="text" name="allergy" pattern="..+" required> <!-- pattern regex to force to be at least two characters. 'required' to require entry. -->
       </div>

       <!--This will create the buttons for either adding or removing allergies -->
       <input type = "submit" value = "Submit" name = "submit">
       <input type = "submit" value = "Remove" name = "remove">

      </form>
    </main>

    <!--Links to all other sections and relevant subsections. -->
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
        <li><a href = "listAllergy.php">Allergy List</a></li>
      </div>

    </footer>
  </body>


</html>
