<?php
require("./lib/file_setup.php");

$filename = $_GET["filename"];

if(!isset($_GET["folder"])) {
  $folder = "/";
} else {
  $folder = $_GET["folder"];
}

if (@file_exists($root.$folder.$filename)) {
  $log="DOWNLOAD\nUser: ".$_SERVER["REMOTE_ADDR"]."\nFile: ".$folder.$filename."\nTime: ".date("Y/m/d H:i:s")."\n";
  $logfile=@fopen("./logfile.txt", "a");
  @fputs($logfile, $log);
  @fclose($logfile);

  $newname = preg_replace( "/(\s)+/i" , "_" , $filename );
  Header("Content-disposition: attachment; filename=" . $newname );
  Header("Content-Length: ".filesize($root.$folder.$filename));
  $file=@fopen($root.$folder.$filename, "rb");
  @fpassthru($file);
  @fclose($file);

  $log="DOWNLOAD COMPLETE\nUser: ".$_SERVER["REMOTE_ADDR"]."\nFile: ".$folder.$filename."\nTime: ".date("Y/m/d H:i:s")."\n";
  $logfile=@fopen("./logfile.txt", "a");
  @fputs($logfile, $log);
  @fclose($logfile);

} else {
  echo("Sorry, could not find file.");
}
?>
