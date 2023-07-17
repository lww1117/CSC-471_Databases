<!DOCTYPE html>
<html>

  <!--Tab name and link to css. -->
  <head>
    <title>Search for a Vaccine!</title>
    <link rel = "stylesheet" href = "styleSheet.css">
  </head>

  <body>

    <!--Page title. -->
    <header class = "vaccine_header">
      <h1>Vaccine Search</h1>
    </header>

    <!--Contains code to search vaccines by disease. -->
    <main class = "vaccine_main">
      <?php

      error_reporting(E_ALL, E_NOTICE);
      ini_set('display_errors', True);

      require 'connDB.php';
      ?>
      <form action="searchVaccines.php" method="post">

        <div>
        <select name="patientId">
         <?php

         #Checks if search button is hit, then it checks if there are any vaccines
         #that treat the selected disease. If there are a dropdown box is populated
         #with the results.
          if(isset($_POST['search'])){
            $data[0] = $_POST['disease'];
            $check = $dbh->prepare("SELECT COUNT(*) FROM vaccine WHERE disease = ?");
            $check->execute([$data[0]]);
            $checkSum = $check->fetchColumn();
            if($checkSum == 1){
              $patientListStmt = $dbh->prepare("SELECT scientific_name FROM vaccine WHERE disease = ?;");
              $patientListStmt->execute([$data[0]]); //execute the statement with no arguments (prepare statement has no ? attributes)
              $patientResults = $patientListStmt->fetchAll();
              for($idx = 0; $idx < count($patientResults); $idx++){
                $p = $patientResults[$idx];
                print("<option value=\"".$p['disease']."\">".$p['scientific_name']."</option>");
              }
            }else{
              echo "No vaccine found.";
            }
          }

        ?>
      </select>
        </div>

        <!--This creates a text box to gather the disease to be used in the vaccine search. -->
        <div>
          Search Vaccines by Disease prevented: <input type = "text" name = "disease" required>
        </div>

        <!--Creates a search button to trigger the method. -->
        <input type = "submit" value = "Search" name = "search"/>
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
        <li><a href = "newVaccine.php">Add, remove, or update a vaccine.</a></li>
        <li><a href = "listVaccines.php">Vaccine list.</a></li>
      </div>
    </footer>
  </body>

</html>
