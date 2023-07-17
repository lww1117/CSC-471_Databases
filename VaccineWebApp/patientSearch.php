<!DOCTYPE html>
<html>

  <!--Tab name and link to css. -->
  <head>
    <title>Find a patient!</title>
    <link rel = "stylesheet" href = "styleSheet.css">
  </head>

  <body>

    <!--Page title. -->
    <header class = "patient_head">
      <h1>Patient Search</h1>
    </header>

    <!--Contains code to search for and remove patient info. -->
    <main class = "patient_main">
      <?php>

      error_reporting(E_ALL);
      ini_set('display_errors', True);

      require 'connDB.php';

      $data[0] = 0;

      #This will populate the array with info grabbed from UUID box.
      if(isset($_POST['UUID'])){
        $data[0] = $_POST['UUID'];
      }

      #Checks if the search button has been clicked and if the UUID box has been
      #filled out. If both are true then a dropbox is populated with all of the
      #patients with that UUID -which should only be one-.
      if(isset($_POST['search'])){
        if(isset($_POST['UUID'])){

          #Make sure the UUID isnt below our starting UUID of 1000.
          $check = $dbh->prepare("SELECT COUNT(*) FROM patients WHERE UUID = ?");
          $check->execute([$data[0]]);
          $checkSum = $check->fetchColumn();
          if($checkSum == 1){
            $newSearch = $dbh->prepare("SELECT * FROM patients WHERE UUID = ?");
            $newSearch->execute([$data[0]]);
            $result = $newSearch->fetch();
            echo $result['first_name'] . " " . $result['middle_initial'] . " " .
            $result['last_name'] . "</br>Ready for input.";
          }else{
            echo "No patient with that UUID found.";
          }
        }
      }

      #Checks if the remove button has been clicked and if the UUID box has been
      #filled out. If both are true it searches if that UUID and then a delete
      #statement is executed.
      if(isset($_POST['remove'])){
        if(isset($_POST['UUID'])){

          #This checks if the UUID already exists within the database. If it does
          #it will continue with the delete statement.
          $check = $dbh->prepare("SELECT COUNT(*) FROM patients WHERE UUID = ?");
          $check->execute([$data[0]]);
          $checkSum = $check->fetchColumn();
          if($checkSum != 0){
            $deletePatient = $dbh->prepare("DELETE FROM patients WHERE UUID = ?");
            $deletePatient->execute([$data[0]]);
            echo "Patient data removed!</br>Ready for input.";
          }else{
            echo "No patient with that UUID found.";
          }
        }
      }

      ?>

      <!--Creates the boxes to gather info for the dropbox. -->
      <form action = "patientSearch.php" method = "post">

        <div>
          Search by UUID: <input type = "number" name = "UUID" min = "1000" required>
        </div>

        <!--This creates the buttons to trigger the methods. -->
        <input type = "submit" value = "Search" name = "search"/>
        <input type = "submit" value = "Remove" name = "remove"/>

      </form>
    </main>
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
        <li><a href = "updatePatient.php">Update patients.</a></li>
        <li><a href = "listPatients.php">Patient list.</a></li>
      </div>

    </footer>

  </body>
</html>
