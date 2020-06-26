<?php
 session_start(); ?>
<?php
    error_reporting(E_ALL ^ E_DEPRECATED);
 ?>

<?php 
    
/*	if (!(if($_SESSION["user"]=="Super User")))
	{
		exit;
	} */

?> 
<html> 
	<body>
	<form action="uploaddata1.php" method="post" name="upload_excel" enctype="multipart/form-data">
	    Upload Type : <select name="uopt" id="uopt"><option>Master</option><option>Monthly</option></select> &nbsp;&nbsp;
		<input type="file" name="file" id="file" class="file_box"/>				  
		<button type="submit" id="submit"  name="submit" class="btn btn-primary button-loading" 
						data-loading-text="Loading...">Show</button>
	</form>
	</body>
</html>
