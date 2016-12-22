<?php
 Header("Content-Type: text/html; charset=big5");
?>

<?php
require("./lib/file_setup.php");

if(!isset($_GET["folder"])) {
  $folder = "/";
} else {
  $folder = $_GET["folder"];
}

$file = $_FILES["file"]["tmp_name"];
$file_name = $_FILES["file"]["name"];
$file_size = $_FILES["file"]["size"];

$target = $root.$folder;

if (!file_exists($target.$file_name)) {
  if (copy($file, $target.$file_name)) {
    $message = "Message:\\n\\t" . $file_name . " Upload success.\\n";
    $message = $message . "\\tFile Size:" . $file_size;
  } else {
    $message = "Error:\\n\\t" . $file_name . " Upload fail.";
  }
} else {
  $message = "Error:\\n\\t" . $file_name . " Exist";
}

$log="UPLOAD\nUser: ".$_SERVER["REMOTE_ADDR"]."\nFile: ".$folder.$file_name."\nTime: ".date("Y/m/d H:i:s")."\n";
$logfile=@fopen("./logfile.txt", "a");
@fputs($logfile, $log);
@fclose($logfile);

?>

<script language="javascript">
alert("<?php echo("$message"); ?>");
this.location="./file.php?folder=<?php echo("$folder"); ?>";
</script>
