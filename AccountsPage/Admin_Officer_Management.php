<!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
       <!-- Compiled and minified CSS -->
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
      <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    </head>

	<body>
	<?php
		include "includes/NavBar.php";
		include 'includes/dbconn.php';
	?>
	<!-- Modal Structure -->
			<div id="myModal" class="modal" >
					<div class="modal-dialog">
					    <div class="modal-content">
						     <div class="modal-header">
						        <h5><center>Edit Record</center></h5>
						      </div>
						      <div class="modal-body">
						      	<div class="row">
						      		<div class="row">
							      		<div class="input-field col s6">
							      			<form class="col s12" method="POST">
								      	 	<LABEL>ID NUMBER</LABEL>
								      		<input type="text" id="texens" name="getID" placeholder="ID NUMBER" readonly>
							      		</div>
							      		<div class="input-field col s6">
									          <input id="sy" type="text" class="validate" placeholder="FE" name="sy" readonly>
									          <label for="sy">School Year</label>
								        </div>
								    </div>
						      		<div class="row">
								        <div class="input-field col s6">
								          <input id="first_name" type="text" class="validate" placeholder="FE" name="fname" readonly>
								          <label for="first_name">First Name</label>
								        </div>
								        <div class="input-field col s6">
								          <input id="last_name" type="text" class="validate" name="lname" placeholder="ID NUMBER" readonly>
								          <label for="last_name">Last Name</label>
								        </div>
							        </div>


							        <div class="row">
								        <div class="input-field col s6">
								          <input id="user_name" type="text" class="validate" name="uname" placeholder="ID NUMBER" readonly>
								          <label for="first_name">Username</label>
								        </div>
								        <div class="input-field col s6">
								          <input id="password" type="password" class="validate" name="pass" placeholder="PASSWORD" required>
								          <label for="last_name">Password</label>
								        </div>
							        </div>
						        </div>
						     </div>
						    <div class="modal-footer">
						      <button class="modal-close waves-effect waves-green btn-flat" data-dismiss="modal">Cancel</button>
						      <button class="modal-close waves-effect waves-green btn-flat" name="reset">RESET</button>
						    </div>
						</div>
						</form>
					</div>
			  </div>
	

	<div id="wrapper">
        <div id="page-wrapper">
        	<div class="container">
	            <center><h3 style="font-family: 'Times New Roman'">List of Officer Accounts</h3></center>
	            	<div class="card mb-3">
				        <div class="card-header">
				        </div>
				        <div class="card-body">
				            <div class="table-responsive">
				            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						        <thead>
						            <tr>
							            <th>ID Number</th>
										<th>First Name</th>
										<th>Last Name</th>
										<th>Account Type</th>
										<th>School Year</th>
										<th>Action</th>
						            </tr>
						        </thead>

						        <tbody>
						        	<?php
						        		$query = "SELECT * FROM accounts a JOIN academia b ON a.idno = b.idno JOIN members c ON b.idno = c.idno where c.p_id != 10";
						        		if(isset($_POST['reset'])){
									  		$idno = $_POST['getID'];
									  		$password = $_POST['pass'];
									  		$sy = $_POST['sy'];
									  		if(mysqli_query($conn, "Update accounts set password = '".md5('$password')."' ,status = 1 where idno = ".$idno)){
									  			$stmt = $conn->prepare($query ." order by sy desc");
									  			echo '<script>alert("Record successfully Reset!")
									  			</script>';
									  			tableBody($stmt);   
									  		}else{
									  			echo '<script>alert("Record not Updated!")
									  			</script>';
									  		}
									  	}else{
	  										$stmt = $conn->prepare($query." order by sy desc");
									  		tableBody($stmt);
									  	}
						        	?>
						        </tbody>
						    </table>
				        	</div>
				        </div>
				  </div>
			  </div> 
        </div>
	</div>


  <!--JavaScript at end of body for optimized loading-->
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


	<!-- Compiled and minified JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>
	<!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
	  
	  <script type="text/javascript">
		(function($) {
		  $('.get_button_more_info').on('click',function() {
		    var obj = $(this).val();
        	obj = JSON.parse(obj);
        	
        	$("#texens").val(obj.idno);
		    $("#first_name").val(obj.fname);
        	$("#last_name").val(obj.lname);
			//$("#password").val(obj.password);
			$("#user_name").val(obj.username);
			$("#sy").val(obj.sy);
		    $("#myModal").modal();

		  });

		})( jQuery );     
		</script>

	  <script type="javascript">
	  	$(document).ready(function(){
	    $('.sidenav').sidenav();
	  });
	  </script>
		
    </body>
  </html>
  <?php
  	function tableBody($stmt){
  		include 'includes/dbconn.php';
  		echo '<script type="text/javascript">
  			var x = document.getElementById("myTable").rows.length;
  			for (i = 0; i < x; i++) { 
			    document.getElementById("myTable").deleteRow(1);
			}
	  		</script>';

		$stmt->execute();
		$result = $stmt->get_result();

		while ($row = $result->fetch_assoc()) {
			$thisDetails = '{ "idno": '.$row['idno'].' , "fname": "'.$row['fname'].'" , "lname": "'.$row['lname'].'" , "password": "'.$row['password'].'" , "username": "'.$row['username'].'" , "sy": "'.$row['sy'].'"}';///to Parse into JSON

			$res = mysqli_query($conn,"SELECT * FROM account_type where type = '".$row['p_id']."'");
			$rowFetch=mysqli_fetch_assoc($res);

			echo "<tr>";
    		echo "<td> ".$row['idno']."</td>";
    		echo "<td> ".$row['fname']."</td>";
    		echo "<td> ".$row['lname']."</td>";
    		echo "<td> ".$rowFetch['account_desc']."</td>";
    		echo "<td> ".$row['sy']."</td>";
    		echo '<td><button type="button" class="btn modal-trigger tag_cnt get_button_more_info" data-target="myModal" value="'.htmlspecialchars($thisDetails).'">Reset</button></td>';
    		echo "</tr>";
		}
  	}
  ?>