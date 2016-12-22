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
$newname = $_GET["newname"];

#$newname = preg_replace( "/(\s)+/i" , "_" , $newname );

$target = $root.$folder;

if (@file_exists($target.$newname)) {
  $message = "Error:\\n\\t" . $newname . " New file name exist).";
} elseif (@rename($target.$name, $target.$newname)) {
  $message = "Message:\\n\\t" . $name . " -> " . $newname . " Rename success.";
} else {
  $message = "Error:\\n\\t" . $name . "->" . $newname . " Rename fail.";
}

  $log="RENAME FOLDER\nUser: ".$_SERVER["REMOTE_ADDR"]."\nOld Folder: ".$folder.$name."\nNew Folder: ".$folder.$newname."\nTime: ".date("Y/m/d H:i:s")."\n";
  $logfile=@fopen("./logfile.txt", "a");
  @fputs($logfile, $log);
  @fclose($logfile);

?>

<script language="javascript">
  alert("<?php echo("$message"); ?>");
  this.location="./file.php?folder=<?php echo("$folder"); ?>";
</script>

