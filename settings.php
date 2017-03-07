<?php
session_start();
include_once 'dbconnect.php';
include_once 'header.php';
?>
<?php 
if (isset($_POST['save'])) {
//Check for profile picture
	if ($_FILES["avi"]["name"] != '') {
//allowed image types
		$allowed_ext = array("jpg", "jpeg", "png");
		$ext = end(explode('.', $_FILES["avi"]["name"]));
		if (in_array($ext, $allowed_ext)) {
			if($_FILES["avi"]["size"]< 2000000) {
				$name = md5(rand()) . '.' . $ext;
				$path = "images/" . $name;
				$move_uploaded_file($_FILES["avi"]["tmp_name"], $path);
			}
			else {
				echo '<script>alert("Image size must be smaller than 2mb.)</script>'
			}
		}
	}
	else {
		echo '<script>alert("Invalid image file.")</script>'
	}
}




?>
<!DOCTYPE html>
<html lang='en'>
<body>
<div class='container'>
	<div class='row justify-content-center'>
		<div class='col-md-4'>
			<form action="#" method="post" enctype="multipart/form-data">
			
			<div class="form-group">
			<label class="custom-file inline">
  			<input type="file" name="avi" id="file" class="custom-file-input col-md-3">
  			<span class="custom-file-control"></span>
			</label>
			<p class="form-text text-muted">
  				Supported image types: .jpg .jpeg. &amp; .png
			</p>
			</div>
		
<!--user type-->			
			<div class="form-group">
			<select class="form-control" name="usertype">
  				<option>aficionado</option>
				<option>professional</option>
				<option>student</option>
				<option>teacher</option>
			</select>
				
			</div>
<!--about-->			
			 <div class="form-group">
			 <label for="aboutuser">Bio</label>
    		 <textarea class="form-control" name="about" rows="4" type="text"></textarea>
			 <p class="form-text text-muted">
  				200 max characters
			</p>
  			 </div>
<!--password-->
		<button class="btn bkg-yellow txt-black f-right" type="submit" name="save" value="save">Save</button>
	</form>
	</div>	
</div>
</div>
	
</div>
<script src="indexscript.js"></script>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>