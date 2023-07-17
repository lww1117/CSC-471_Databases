<!DOCTYPE html>
<html>

  <!--Tab name and link to css. -->
  <head>
    <title>Create a patient!</title>
    <link rel = "stylesheet" href = "styleSheet.css">
  </head>
  <body>

    <!--Page title. -->
    <header class = "patient_head">
      <h1>Patient Creation</h1>
    </header>

    <!--Contains code to add new patients to the database. -->
    <main class = "patient_main">
      <?php>

      error_reporting(E_ALL, E_NOTICE);
      ini_set('display_errors', True);

      require 'connDB.php';

      #These grab the values for each field from the text boxes and store them include
      #an array.
      if(isset($_POST['UUID'])){
        $data[0] = $_POST['UUID'];
      }

      if(isset($_POST['first_name'])){
        $data[1] = $_POST['first_name'];
      }

      #This will take whatever string is entered into the middle_initial text box
      #and only grab the first letter.
      if(isset($_POST['middle_initial'])){
        $dataMI = $_POST['middle_initial'];
        $data[2] = substr($dataMI, 0, 1);
      }

      if(isset($_POST['last_name'])){
        $data[3] = $_POST['last_name'];
      }

      if(isset($_POST['d_o_b'])){
        $data[4] = $_POST['d_o_b'];
      }

      if(isset($_POST['weight'])){
        $data[5] =$_POST['weight'];
      }

      #This checks if the add button has been clicked and then takes the created
      #array and uses it for an insert statement.
      if(isset($_POST['add'])){

        if(isset($data[1],$data[2],$data[3],$data[4],$data[5])){

          $lastUUID = $dbh->prepare("SELECT TOP 1 UUID FROM patients ORDER BY UUID DESC");
          $lastUUID->execute();
          $data[0] = $lastUUID->fetchColumn() + 1;

          $patientInsert = $dbh->prepare("INSERT INTO patients (UUID, first_name, middle_initial,
          last_name, d_o_b, weight) VALUES (?, ?, ?, ?, ?, ?);");
          $patientInsert->execute([$data[0],$data[1],$data[2],$data[3],$data[4],$data[5],]);

          echo "Patient added!</br>";
        }
        else{
          echo "Please fill out all fields. </br>";
        }
      }

      ?>

      <!--This creates the boxes to grab values for the insert, they are all set
    to required and the d_o_b field and weight field have their input type set so
  their input has to be formatted correctly before it is accepted.-->
      <form action = "newPatients.php" method = "post">
        <div>
          Patient First Name: <input type = "text" name = "first_name" required>
        </div>
        <div>
          Patient Middle Initial <input type "text" name = "middle_initial" required>
        </div>
        <div>
          Patient Last Name: <input type = "text" name = "last_name" required>
        </div>
        <div>
          Patient Date of Birth: <input type = "date" name = "d_o_b" required>
        </div>
        <div>
          Patient weight: <input type = "number" name = "weight" required min = "0"
          max = "500">
        </div>

        <!--This will create the submit button to start the process of making the
      insert statement. -->
        <input type = "submit" value = "Add" name = "add"/>

      </form>
    </main>

    <!--Links to all other sections and relevant subsections. -->
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
        <li><a href = "patientSearch.php">Search or remove a patient.</a></li>
        <li><a href = "updatePatient.php">Update patients.</a></li>
        <li><a href = "listPatients.php">Patient list.</a></li>
      </div>

    </footer>
  </body>
</html>
