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

if(@mkdir("$target$name", 0777)) {
  $message = "Message:\\n\\t" . $name . " Folder create success.";  
} else {
  $message = "Error:\\n\\t". $name . " Folder create fail.";
}

  $log="NEW FOLDER\nUser: ".$_SERVER["REMOTE_ADDR"]."\nFolder: ".$folder.$name."\nTime: ".date("Y/m/d H:i:s")."\n";
  $logfile=@fopen("./logfile.txt", "a");
  @fputs($logfile, $log);
  @fclose($logfile);

?>

<script language="javascript">
alert("<?php echo("$message"); ?>");
this.location="./file.php?folder=<?php echo("$folder"); ?>";
</script>
