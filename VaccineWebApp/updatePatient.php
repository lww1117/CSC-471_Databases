<!DOCTYPE html>
<html>

  <!--Tab name and link to css. -->
  <head>
    <title>Update/Remove a Patient!</title>
    <link rel = "stylesheet" href = "styleSheet.css">
  </head>

  <body>

    <!--Page title. -->
    <header class = "patient_head">
      <h1>Patient Update</h1>
    </header>

    <!--Contains code to list all patients and then use that info to update a specific
  patient. -->
    <main class = "patient_main">
      <?php>

      error_reporting(E_ALL);
      ini_set('display_errors', True);

      require 'connDB.php';

      #Grabs the UUID from the dropdown box.
      if(isset($_POST['UUID'])){
        $data[0] = $_POST['UUID'];
      }

      #Checks if update button is clicked and if so checks if patient already exists.
      #If so, then the update statement is executed.
      if(isset($_POST['update'])){
          $data[1] = $_POST['first_name'];
          #Takes the middle_initial and takes only the first letter as the true
          #middle_initial.
          $dataMI = $_POST['middle_initial'];
          $data[2] = substr($dataMI, 0, 1);
          $data[3] = $_POST['last_name'];
          $data[4] = $_POST['d_o_b'];
          $data[5] = $_POST['weight'];
          $newSearch = $dbh->prepare("UPDATE patients SET first_name = ?, middle_initial = ?,
            last_name = ?, d_o_b = ?, weight = ? WHERE UUID = ?");
          $newSearch->execute([$data[1], $data[2], $data[3], $data[4], $data[5], $data[0]]);
          echo "Patient Updated!";
        }else{
          echo "Please choose a patient to be updated.";
        }

      ?>

      <form action = "updatePatient.php" method = "post">

        <!--Creates a dropdown box with all of the patients in the database which
      will return their UUID upon selection. -->
        <div>
        <select name="UUID">
        <?php
          $patientListStmt = $dbh->prepare("SELECT UUID, first_name, middle_initial,
            last_name, d_o_b, weight FROM patients;");
          $patientListStmt->execute(); //execute the statement with no arguments (prepare statement has no ? attributes)
          $patientResults = $patientListStmt->fetchAll();
          for($idx = 0; $idx < count($patientResults); $idx++){
            $p = $patientResults[$idx];
            print("<option value=\"".$p['UUID']."\">".$p['UUID'].", ".$p['first_name'].
            ", ".$p['middle_initial'].", ".$p['last_name'].", ".$p['d_o_b'].", ".
            $p['weight']."</option>");
          }
        ?>
        </select>

        </div>


        <!--Creates input boxes to take in new data for patient updates. -->
        <div>
          Change First Name: <input type = "text" name = "first_name" required>
        </div>
        <div>
          Change Middle Initial: <input type = "text" name = "middle_initial"  required>
        </div>
        <div>
          Change Last Name: <input type = "text" name = "last_name"  required>
        </div>
        <div>
          Change Date of Birth: <input type = "date" name = "d_o_b"  required>
        </div>
        <div>
          Change Weight: <input type = "number" name = "weight" min = "0"  required>
        </div>

        <!--Creates button to trigger method. -->
        <input type = "submit" value = "Update" name = "update"/>
        </form>
    </main>

    <!--Links to all sections and relevant subsections. -->
    <footer class = "patient_footer">
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
        <h2>Patient Directory</h2>
        <li><a href = "newPatients.php">Add a patient.</a></li>
        <li><a href = "patientSearch.php">Search or remove a patient.</a></li>
        <li><a href = "listPatients.php">Patient list.</a></li>
      </div>

    </footer>

  </body>
</html>
