<?php require '../prog01/database.php'; 
$id = null;
if (!empty($_GET['id'])) {
	$id = $_REQUEST['id'];
}

// if data was entered by the user
if (isset($_POST['update'])) {	
	// get values
	$id = $_POST['id'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
	
	$valid = true;
	if (empty($name) || empty($email) || empty($mobile)) {
		$valid = false;
	} 
	
	// update data
	if ($valid) {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE customers  set name = ?, email = ?, mobile = ? WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($name,$email,$mobile,$id));
		Database::disconnect();
	}
} else {
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// do not select * because we do not want the server to SEND password
	$sql = "SELECT id, name, email, mobile FROM customers where id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	$name = $data['name'];
	$email = $data['email'];
	$mobile = $data['mobile'];
	Database::disconnect();
}
?> 
<div class="container">
	<div class="span10 offset1">
		<div class="row">
			<h3>Update a Customer</h3>
		</div>
		<form class="form-horizontal">
			<div class="control-group">
				<label class="control-label">Name</label>
				<div class="controls">
					<input id="name" type="text" placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Email Address</label>
				<div class="controls">
					<input id="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Mobile Number</label>
				<div class="controls">
					<input id="mobile" type="text" placeholder="Mobile Number" value="<?php echo !empty($mobile)?$mobile:'';?>">
				</div>
			</div>
		</form>
	</div>
</div> <!-- /container -->

