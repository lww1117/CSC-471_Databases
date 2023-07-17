<!DOCTYPE html>
<html>

  <!--Tab name and link to css. -->
  <head>
    <title>Vaccine Registration!</title>
    <link rel = "stylesheet" href = "styleSheet.css">
  </head>

  <body>

    <!--Page title. -->
    <header class = "vaccine_header">
      <h1>Vaccine Log</h1>
    </header>

    <!--Contains code to add, remove, or update vaccine information. -->
    <main class = "vaccine_main">
      <?php>

      error_reporting(E_ALL, E_NOTICE);
      ini_set('display_errors', True);

      require 'connDB.php';

      #Takes info from boxes and places them into array.
      if(isset($_POST['scientific_name'])){
        $data[0] = $_POST['scientific_name'];
      }

      if(isset($_POST['disease'])){
        $data[1] = $_POST['disease'];
      }

      if(isset($_POST['num_doses'])){
        $data[2] = $_POST['num_doses'];
      }


      #This will check if the vaccine information already exists. If it does not
      #the vaccine information will be inserted into the database.
      if(isset($_POST['add'])){

        $check = $dbh->prepare("SELECT COUNT(*) FROM vaccine WHERE scientific_name = ?
        AND disease = ? AND num_doses = ?;");
        $check->execute([$data[0], $data[1], $data[2]]);
        $checkSum = $check->fetchColumn();
        if($checkSum == 0){
          $vaccineInsert = $dbh->prepare("INSERT INTO vaccine (scientific_name, disease, num_doses
          ) VALUES (?, ?, ?);");
          $vaccineInsert->execute([$data[0],$data[1],$data[2]]);

          echo "Vaccine added!</br>Ready for input.";
        }else{
          echo "Vaccine already exists!</br>Ready for input.";
        }

      }

      #This will check if the vaccine already exists within the database. If it
      #does then the delete statement will remove it from the database.
      if(isset($_POST['remove'])){

        $check = $dbh->prepare("SELECT COUNT(*) FROM vaccine WHERE scientific_name = ?
        AND disease = ? AND num_doses = ?;");
        $check->execute([$data[0], $data[1], $data[2]]);
        $checkSum = $check->fetchColumn();
        if($checkSum != 0){
          $vaccineDelete = $dbh->prepare("DELETE FROM vaccine WHERE scientific_name = ?
          AND disease = ? AND num_doses = ?;");
          $vaccineDelete->execute([$data[0], $data[1], $data[2]]);

          echo "Vaccine removed!</br>Ready for input.";
        }else{
          echo "Vaccine not found!</br>Ready for input.";
        }
      }

      #This will check for the scientific name of a vaccine, and if it exists the
      #disease and number of doses will be updated for it.
      if(isset($_POST['update'])){
        $check = $dbh->prepare("SELECT COUNT(*) FROM vaccine WHERE scientific_name = ?;");
        $check->execute([$data[0]]);
        $checkSum = $check->fetchColumn();
        if($checkSum != 0){
          $vaccineUpdate = $dbh->prepare("UPDATE vaccine SET disease = ?, num_doses = ?
             WHERE scientific_name = ?;");
          $vaccineUpdate->execute([$data[1], $data[2], $data[0]]);

          echo "Vaccine updated!</br>Ready for input.";
        }else{
          echo "Vaccine not found.</br>Ready for input.";
        }
      }

      ?>

      <!--This will create text boxes for gathering information about the vaccine -->
      <form action = "newVaccine.php" method = "post">
        <div>
          Vaccine Scientific Name: <input type = "text" name = "scientific_name" required>
        </div>
        <div>
          Disease Prevented: <input type "text" name = "disease" required>
        </div>
        <div>
          Number of Doses Required: <input type = "number" name = "num_doses" required min = "1">
        </div>

        <!--This creates the buttons to trigger each method. -->
        <input type = "submit" value = "Add" name = "add"/>
        <input type = "submit" value = "Remove" name = "remove"/>
        <input type = "submit" value = "Update" name = "update"/>
      </form>
    </main>

    <!--Links to all sections and relevant subsections. -->
    <footer class = "vaccine_footer">
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
        <h2>Vaccine Directory</h2>
        <li><a href = "searchVaccines.php">Search for a vaccine.</a></li>
        <li><a href = "listVaccines.php">Vaccine list.</a></li>
      </div>
    </footer>
  </body>
</html>
