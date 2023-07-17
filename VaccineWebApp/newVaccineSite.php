<html>

  <!--Tab name and link to css. -->
  <head>
    <title>Add/Remove/Update a Vaccine Site!</title>
    <link rel = "stylesheet" href = "styleSheet.css">
  </head>

  <body>

    <!--Page title. -->
    <header class = "vaccine_site_header">
      <h1>Insert, Delete, or Update a Vaccine Site</h1>
    </header>

    <!--Contains code to add, remove, or update a vaccine site. -->
    <main class = "vaccine_site_main">
      <?php
      //Enable showing error messages
      error_reporting(E_ALL, E_NOTICE);
      ini_set('display_errors', True);

      require 'connDB.php';

      #Gathers the necessary info from the boxes and populates the array.
      if(isset($_POST['site_name'])){
        $data[0] = $_POST['site_name'];
      }

      if(isset($_POST['site_street'])){
        $data[1] = $_POST['site_street'];
      }

      if(isset($_POST['site_city'])){
        $data[2] = $_POST['site_city'];
      }

      if(isset($_POST['site_state'])){
        $data[3] = $_POST['site_state'];
      }

      if(isset($_POST['site_zipcode'])){
        $data[4] = $_POST['site_zipcode'];
      }

      #Checks if the add button has been clicked and if the vaccine site already
      #exists. If the button is clicked and no duplicate vaccine site exists, then
      #the insert statement is executed.
      if(isset($_POST['add'])){
        $check = $dbh->prepare("SELECT COUNT(*) FROM vaccine_site WHERE site_name = ?;");
        $check->execute([$data[0]]);
        $checkSum = $check->fetchColumn();
        if($checkSum == 0){
          $vaccineSiteInsert = $dbh->prepare("INSERT INTO vaccine_site (site_name, site_street,
            site_city, site_state, site_zipcode) VALUES (?, ?, ?, ?, ?);");
          $vaccineSiteInsert->execute([$data[0], $data[1], $data[2], $data[3], $data[4]]);
          echo "Vaccine site added!</br>Ready for input.";

        }else{
            echo "Vaccine site already exists!</br>Ready for input.";
        }
      }

      #Checks if the remove button has been clicked and if the vaccine site already
      #exists in the database. If the button is clicked and the vaccine site already
      #exists, then the delete statement is executed.
      if(isset($_POST['remove'])){
        $check = $dbh->prepare("SELECT COUNT(*) FROM vaccine_site WHERE site_name = ?;");
        $check->execute([$data[0]]);
        $checkSum = $check->fetchColumn();
        if($checkSum != 0){
          $vaccineSiteDelete = $dbh->prepare("DELETE FROM vaccine_site WHERE site_name = ?;");
          $vaccineSiteDelete->execute([$data[0]]);
          echo "Vaccine removed!</br>Ready for input.";
        }else{
          echo "Vaccine not found!</br>Ready for input.";
        }
      }

      #Checks if the update button is clicked and if the vaccine site name already
      #exists within the database. If the button is click and the site name already
      #exists, then the update statement is executed.
      if(isset($_POST['update'])){
        $check = $dbh->prepare("SELECT COUNT(*) FROM vaccine_site WHERE site_name = ?;");
        $check->execute([$data[0]]);
        $checkSum = $check->fetchColumn();
        if($checkSum != 0){
          $vaccineSiteUpdate = $dbh->prepare("UPDATE vaccine_site SET site_street = ?, site_city = ?,
            site_state = ?, site_zipcode = ? WHERE site_name = ?;");
          $vaccineSiteUpdate->execute([$data[1], $data[2], $data[3], $data[4], $data[0]]);
          echo "Vaccine site updated!</br>Ready for input.";
        }else{
          echo "Vaccine site not found.</br>Ready for input.";
        }
      }

      ?>

      <!--This will gather the information for the array in text boxes. -->
      <form action = "newVaccineSite.php" method = "post">
        <div>
          Vaccine Site name: <input type = "text" name = "site_name" required>
        </div>
        <div>
          Vaccine Site Street name: <input type "text" name = "site_street" required>
        </div>
        <div>
          Vaccine Site City name: <input type "text" name = "site_city" required>
        </div>
        <div>
          Vaccine Site State name: <input type "text" name = "site_state" required>
        </div>
        <div>
          Vaccine Site Zipcode: <input type "number" name = "site_zipcode" required min = "00000"
          max = "99999">
        </div>

        <!--This creates the buttons to trigger the methods. -->
        <input type = "submit" value = "Add" name = "add"/>
        <input type = "submit" value = "Remove" name = "remove"/>
        <input type = "submit" value = "Update" name = "update"/>



      </form>
    </main>

    <!--Links to all sections and relevant subsections. -->
    <footer class = "vaccine_site_footer">
      <div>
        <h2>Main Directory</h2>
        <li><a href = "index.php">Return to Main menu</a></li>
        <li><a href = "patientPortal.php">Return to Patient menu</a></li>
        <li><a href = "allergyPortal.php">Return to Allergy menu</a></li>
        <li><a href = "vaccinePortal.php">Return to Vaccine menu</a></li>
        <li><a href = "recordsPortal.php">Return to records menu</a></li>
      </div>
      <div>
        <h2>Vaccine Site Directory</h2>
        <li><a href = "searchVaccineSites.php">Search for a vaccine site.</a></li>
        <li><a href = "listVaccineSites.php">List of vaccine sites.</a></li>
      </div>

    </footer>

  </body>
</html>
