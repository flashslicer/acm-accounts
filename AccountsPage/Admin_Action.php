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
            <center><h3 style="font-family: 'Times New Roman'">Admin</h3></center>
            <div class="divider"></div>
              <div class="container">
                <div class="row">
                  <form method="POST">
                    <div class="input-field col s12">
                    <center><button class="btn waves-effect waves-light" type="submit" name="delete">Delete All Active
                      <i class="large material-icons right">delete_sweep</i>
                    </button></center>
                </div>
                  </form>
                </div>

                <form method="POST">
                  <div class="row">
                      <div class="input-field col s5 offset-s3">
                        <input id="Student_Number" type="text" class="validate" name="idno" required>
                        <label for="Student_Number">Student Number</label>
                      </div>
                      <div class="input-field col s3">
                      <button class="btn waves-effect waves-light" type="submit" name="check">Search
                        <i class="material-icons right">search</i>
                      </button>
                    </div>
                  </div>
                </form>

                <?php
                  $result = mysqli_query($conn, "SELECT * from school_year where status = 1");
                  $row = mysqli_fetch_array($result);     
                  $sy = $row['sy'];
                if(isset($_POST['check'])){
                   
                    $stmt = $conn->prepare("SELECT * FROM accounts a JOIN academia b ON a.idno = b.idno JOIN members c ON b.idno = c.idno where a.idno = ? and c.sy = ".$sy);

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
                              $res = mysqli_query($conn, "SELECT * from account_type where type = ".$row['p_id']."");
                              $rowu = mysqli_fetch_array($res);  

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
                              echo '</div>';

                              echo '<div class="row">';
                              echo '  <div class="input-field col s6">';
                              echo '    <input type = "text" name = "uname" class="validate" value="'.$idno.'" readonly>';
                              echo '    <label for="password">User Name</label>';
                              echo '  </div>';
                              echo '  <div class="input-field col s6">';
                              echo '    <input type = "text" name = "uname" class="validate" value="'.$row['status'].'" readonly>';
                              echo '    <label for="password">Status</label>';
                              echo '  </div>';
                              echo '</div>';
                              echo '<div class="row">';
                              echo '  <div class="input-field col s6 offset-s3">';
                              echo '    <input type = "text" name = "uname" class="validate" value="'.strtoupper($rowu['account_desc']).'" readonly>';
                              echo '    <label for="password">Account Type</label>';
                              echo '  </div>';
                              echo '</div>';
                              $buttonDis = "";
                              if($row['status'] == 0){
                                $buttonDis = " disabled";
                              }
                              echo '<div class="row">';
                              echo '  <div class="input-field col s6 offset-s5">';
                              echo '    <button class="btn waves-effect waves-light" type="submit" name="sub" '.$buttonDis.'>Delete';
                              echo '      <i class="material-icons right">delete</i>';
                              echo '    </button>';
                              echo '  </div>';
                              echo '</div>';
                              echo '</form>';
                        }
                    }
                }
                if(isset($_POST['sub'])){

                  $idno = $_POST['id'];
                  $deleteAccount = "Update accounts a INNER JOIN members b ON a.idno = b.idno SET a.status = 0 where a.idno = ".$idno." AND b.sy = ".$sy;
                  
                  if(mysqli_query($conn,$deleteAccount)){
                        echo '<div class="card green darken-0">';
                        echo '  <div class="row">';
                        echo '    <div class="col s12">';
                        echo '      <div class="card-content white-text">';
                        echo '          <center>Record Successfully Deleted!</center>';
                        echo '      </div>';
                        echo '    </div>';
                        echo '  </div>';
                        echo '</div>';
                  }
                }

                if(isset($_POST['delete'])){
                  $deleteAllAccount = "Update accounts a INNER JOIN members b ON a.idno = b.idno SET a.status = 0 where b.sy = ".$sy;
                  
                  if(mysqli_query($conn,$deleteAllAccount)){
                        echo '<div class="card green darken-0">';
                        echo '  <div class="row">';
                        echo '    <div class="col s12">';
                        echo '      <div class="card-content white-text">';
                        echo '          <center>All Record Successfully Deleted!</center>';
                        echo '      </div>';
                        echo '    </div>';
                        echo '  </div>';
                        echo '</div>';
                  }
                }
                ?>
              </div>
        </div>
  </div>
</div>

      <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
  </body>
  </html>
