<?php session_start(); ?>
<?php
//$file = $_POST['fname'];
//echo $file;
//return;
$file=$_SESSION['dfname'];
echo $file;
if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
//	echo $file;
    exit;
}
else
{
//	echo "file not found";
}
?> 