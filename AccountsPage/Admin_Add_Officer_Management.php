 <!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
 
  <body bgcolor="#FFFFFF">
  <?php 
  include 'includes/NavBar.php';
  include 'includes/dbconn.php';
  ?>
  
  <div id="wrapper">
        <div id="page-wrapper">
            <center><h3 style="font-family: 'Times New Roman'">Add a New Officer</h3></center>
            <div class="divider"></div>
              <div class="container">
                <form method="POST">
                  <div class="row">
                      <div class="input-field col s6 offset-s3">
                        <input id="Student_Number" type="text" class="validate" name="idno" required>
                        <label for="Student_Number">Student Number</label>
                      </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s6 offset-s5">
                      <button class="btn waves-effect waves-light" type="submit" name="check">Check
                        <i class="material-icons right">check</i>
                      </button>
                    </div>
                  </div>
                </form>

                <?php
                if(isset($_POST['check'])){
                   
                    $stmt = $conn->prepare("SELECT * FROM members a JOIN academia b ON a.idno = b.idno where a.idno = ?");

                    $idno = strip_tags($_POST['idno']);

                    $stmt->bind_param("i",$idno);
                    $stmt->execute();
                    $stmt->store_result();
                    //$result = mysqli_query($conn, "SELECT * from academia where idno = ".$idno );

                    //if(mysqli_num_rows($result) == 0){
                    if($stmt->num_rows == 0){
                        echo '<div class="card red darken-0">';
                        echo '  <div class="row">';
                        echo '    <div class="col s12">';
                        echo '      <div class="card-content white-text">';
                        echo '          <center>No Data Found!</center>';
                        echo '      </div>';
                        echo '    </div>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                          $stmt->execute();
                          $result = $stmt->get_result();
                          while ($row = $result->fetch_assoc()) {
                              echo '<form method = "POST">';
                              echo '<div class="row">';
                              echo '  <div class="input-field col s6">';
                              echo '    <input type = "text" name = "fname" class="validate" value="'.$row['fname'].'" readonly>';
                              echo '    <input type = "hidden" name = "id" class="validate" value="'.$idno.'" readonly>';
                              echo '    <label for="password">First Name</label>';
                              echo '  </div>';
                              echo '  <div class="input-field col s6">';
                              echo '    <input type = "text" name = "lname" class="validate" value="'.$row['lname'].'" readonly>';
                              echo '    <label for="password">Last Name</label>';
                              echo '  </div>';

                              echo '<div class="row">';
                              echo '  <div class="input-field col s6 offset-s3">';
                              echo '    <input type = "text" name = "uname" class="validate" value="'.$row['idno'].'" readonly>';
                              echo '    <label for="password">User Name</label>';
                              echo '  </div>';
                              echo '</div>';


                              $result = mysqli_query($conn, "SELECT * from account_type where type != 10 AND type != 1");

                              echo ' <label><center>Type</center></label>';
                              echo '  <div class="input-field col s6 offset-s3">';
                              echo '    <select class="browser-default" name="accType" required>';
                              echo '      <option value="" disabled selected>Choose your option</option>';

                              while ($row=mysqli_fetch_assoc($result)){
                                  echo '      <option value="'.$row['type'].'">'.$row['account_desc'].'</option>';
                              }
                              echo '    </select>';
                              echo '  </div>';
                              
                              echo '<div class="row">';
                              echo '  <div class="input-field col s6 offset-s5">';
                              echo '    <button class="btn waves-effect waves-light" type="submit" name="sub">Submit';
                              echo '      <i class="material-icons right">send</i>';
                              echo '    </button>';
                              echo '  </div>';
                              echo '</div>';
                              echo '</form>';
                        }
                    }
                }
                if(isset($_POST['sub'])){
                  
                  $idno = $_POST['id'];
                  $username = $_POST['uname'];
                  $accType = $_POST['accType'];

                  $res = mysqli_query($conn,"SELECT * FROM members where p_id = ".$accType." AND sy = (SELECT sy FROM school_year WHERE status = 1) AND p_id != 9");
                  $rows = mysqli_fetch_array($res);

                  if(mysqli_num_rows($res) == 1){
                      ?>
                        <div class="card red darken-0">
                          <div class="row">
                            <div class="col s12">
                              <div class="card-content white-text">
                                  <center>Account Type Already Existing this School Year!</center>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php
                  }else{
                      $updateMember = "UPDATE members a, accounts b Set a.p_id = ".$accType.", b.type = ".$accType." where a.idno = ".$idno." AND b.idno = ".$idno." AND a.sy = (SELECT sy from school_year where status = 1)";
                      if(mysqli_query($conn,$updateMember)){
                        echo '<div class="card green darken-0">';
                        echo '  <div class="row">';
                        echo '    <div class="col s12">';
                        echo '      <div class="card-content white-text">';
                        echo '          <center>Record Successfully Added!</center>';
                        echo '      </div>';
                        echo '    </div>';
                        echo '  </div>';
                        echo '</div>';
                      }
                  }
                }
                ?>
              </div>
        </div>
  </div>

      <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
  </body>
  </html>
