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

$name = $_GET["name"];

$target = $root.$folder;

if (@!file_exists($target.$name)) {
  $message = "Error:\\n\\t" . $name . " Folder not exist).";
} elseif (@rmdir($target.$name)) {
  $message = "Message:\\n\\t" . $name . " Folder delete success.";
} else {
  $message = "Error:\\n\\t" . $name . " Folder delete fail.\\n\\t(it may be not empty folder.)";
}

  $log="DELETE FOLDER\nUser: ".$_SERVER["REMOTE_ADDR"]."\nFolder: ".$folder.$name."\nTime: ".date("Y/m/d H:i:s")."\n";
  $logfile=@fopen("./logfile.txt", "a");
  @fputs($logfile, $log);
  @fclose($logfile);

?>

<script language="javascript">
  alert("<?php echo("$message"); ?>");
  this.location="./file.php?folder=<?php echo("$folder"); ?>";
</script>
