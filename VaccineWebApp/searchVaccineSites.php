<!DOCTYPE html>
<html>

  <!--Tab name and link to css. -->
  <head>
    <title>Search for a Vaccine Site!</title>
    <link rel = "stylesheet" href = "styleSheet.css">
  </head>

  <body>

    <!--Page title. -->
    <header class = "vaccine_site_header">
      <h1>Vaccine Site Search</h1>
    </header>

    <!--Contains code to search vaccine sites by vaccine site name. -->
    <main class = "vaccine_site_main">
      <?php

      error_reporting(E_ALL, E_NOTICE);
      ini_set('display_errors', True);

      require 'connDB.php';
      ?>
      <form action="searchVaccineSites.php" method="post">

        <div>
        <select name="patientId">
         <?php

         #Checks if the search button has been clicked and if the vaccination site
         #name exists within the database. If it exists then the dropdown box will
         #be populated with the results from the search.
          if(isset($_POST['search'])){
            $data[0] = $_POST['site_name'];
            $check = $dbh->prepare("SELECT COUNT(*) FROM vaccine_site WHERE site_name = ?");
            $check->execute([$data[0]]);
            $checkSum = $check->fetchColumn();
            if($checkSum == 1){
              $vaccineSiteListStmt = $dbh->prepare("SELECT site_name, site_street, site_city,
                site_state, site_zipcode FROM vaccine_site WHERE site_name = ?;");
              $vaccineSiteListStmt->execute([$data[0]]); //execute the statement with no arguments (prepare statement has no ? attributes)
              $vaccineSiteResults = $vaccineSiteListStmt->fetchAll();
              for($idx = 0; $idx < count($vaccineSiteResults); $idx++){
                $p = $vaccineSiteResults[$idx];
                print("<option value=\"".$p['site_name']."\">".$p['site_name'].", ".$p['site_street'].
                ", ".$p['site_city'].", ".$p['site_state'].", ".$p['site_zipcode']."</option>");
              }
            }else{
              echo "No vaccination site by that name found.";
            }
          }

        ?>
      </select>
        </div>

        <!--Creates the text box to gather the site name for the search. -->
        <div>
          Search Vaccine Sites by Site Name: <input type = "text" name = "site_name" required>
        </div>

        <!--Creates the button to trigger the method. -->
        <input type = "submit" value = "Search" name = "search"/>



      </form>
    </main>

    <!--Links to all sections and all relevant subsections. -->
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
        <li><a href = "newVaccineSite.php">Add, remove, or update a vaccine site.</a></li>
        <li><a href = "listVaccineSites.php">List of vaccine sites.</a></li>
      </div>

    </footer>
  </body>

</html>
