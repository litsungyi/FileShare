<?php
require("./lib/file_setup.php");

if(!isset($_GET["folder"])) {
  $folder = "/";
} else {
  $folder = $_GET["folder"];
}

$filename = $_GET["filename"];

$showfile=true;
if($filename!="") {
  $dot=strrpos($filename, ".");
  if ($dot) {
    $ext=(substr($filename, $dot+1));

    switch ($ext) {
      case "bmp"	:
        $ContentType="image/bmp";
        break;
      case "jpg"	:
      case "jpeg"	:
        $ContentType="image/jpeg";
        break;
      case "gif"	:
        $ContentType="image/gif";
        break;
      case "png"	:
        $ContentType="image/png";
        break;
      case "txt"	:
      case "cpp"	:
      case "c"		:
      case "java"	:
      case "sql"	:
      case "inc"	:
      case "css"	:
      case "js"		:
      case "php"	:
        $ContentType="text/plain";
        break;
      case "shtml"	:
      case "html"	:
      case "htm"	:
      case "xhtml"	:
      case "xml"	:
      case "xsl"        :
        $ContentType="text/html";
        break;
      default		:
        $showfile=false;
    }

    if ($showfile) {
      $filepath = $root.$folder.$filename;
      $fp = fopen($filepath, 'rb');

      header("Content-Location: ".$filename);
      header("Content-Type: ".$ContentType."; charset=big5");
      header("Content-Length: " . filesize($filepath));

      fpassthru($fp);
    } else {
      $link = "downfile.php?folder=$folder&filename=$filename";
      
      echo("This file can't preview.");
      echo("<br/>Only can preview  *.bmp; *.jpg; *.jpeg; *.gif; *.png; *.txt; *.cpp; *.c; *.java; *.sql; *.inc; *.css; *.js; *.php; *.shtml; *.html; *.htm; *.xhtml; *.xml; *.xsl; ");
      echo("<br/>Press <a href=\"$link\">here</a> to Download");
    }
  }
} else {
  echo("Could not find file " . $filename . ".");
}

  $log="SHOW\nUser: ".$_SERVER["REMOTE_ADDR"]."\nFile: ".$folder.$filename."\nTime: ".date("Y/m/d H:i:s")."\n";
  $logfile=@fopen("./logfile.txt", "a");
  @fputs($logfile, $log);
  @fclose($logfile);
?>
