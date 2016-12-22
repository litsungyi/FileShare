<?php
 Header("Content-Type: text/html; charset=big5");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<?php
  require("./lib/set_cookie.php");
?>
<html lang="zh-tw">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=big5">
<meta name="author" content="Li Tsung-Yi (litsungyi@gmail.com)">
<meta name="Copyright" content="Copyright &copy; 2010 by Li Tsung-Yi All Rights Reserved.">

<title>Web Folder - <?php echo($_SERVER["REMOTE_ADDR"]); ?></title>

<?php
  require("./lib/file_setup.php");
?>

<style type="text/css">
<!--
<?php
  require("./lib/file_style.php");
?>
-->
</style>

<script type="text/javascript" src="./script/file.js"></script>
</head>
<body>

<div>請關閉 Firefox 的阻擋彈出視窗功能或用 IE 重試<br/>無法下載請與我聯絡 <a href="msnim:chat?contact=caesar@ms38.url.com.tw">MSN(IE only)</a> or <a href="mailto:tsungyilee@igs.com.tw">Mail</a></div>

<?php
// if no input folder
// set locale folder is root
if(!isset($_GET["folder"])) {
  $folder = "/";
} else {
  $folder = $_GET["folder"];
}

$target = $root . $folder;

$dir = dir($target);

if ($dir == null) {
  $folder = "/";
  $target = $root . $folder;
  $dir = dir($target);
}

$dir->rewind();

$file_list	= array();
$dir_list	= array();

// read folder files
while ($file=$dir->read()) {
  if($file != "." && $file != "..") {
    $file_path = $target . $file;

    if(is_dir($file_path)) {
      $dir_list[count($dir_list)] = $file;
    } else {
      $file_list[count($file_list)] = $file;
    }
  }
}
?>
<form action="" enctype="multipart/form-data" name="FileForm" id="FileForm" method="post">
<table width="100%">
  <tr>
    <td colspan="8" class="title">
      You are current at folder: <span class="folder"><?php echo($folder); ?></span>
<?php
$upload = false;
$perms = fileperms(substr($target, 0, strlen($target)-1));
if (($perms & 0x0002)) {
  $upload = true;
}
?>
    </td>
  </tr>
  <tr>
    <td colspan="8" class="button">
      <button class="button0" DISABLED>SELECT ALL</button>
      <button class="button0" DISABLED>SELECT NONE</button>
      <button class="button0" onclick="FMkDir('<?php echo($folder); ?>');">MAKE NEW DIR</button>
      <button class="button0" DISABLED>MAKE NEW FILE</button>
      <button class="button0" onclick="ChgStyle('<?php echo($folder); ?>', '<?php echo(++$style % 2); ?>');">CHANGE STYLE</button>
    </td>
  </tr>
  <tr>
    <td colspan="8" class="button">
      <input type="hidden" name="MAX_FILE_SIZE" value="1073741824">
      <label for="file">SELECT FILE:</label>
      <input type="file" name="file" id="file" size="20">
      <button class="button1" onclick="FUpload('<?php echo($folder); ?>')" <?php if(!$upload) echo("disabled"); ?>>UPLOAD FILE</button>
      <span class="note">(Maximum Size: 1G)</span>
    </td>
  </tr>
<?php
$countJ = 0;

// if not at root
// show go parent folder
if ($target != $root . "/") {
  $countI = strrpos(substr($folder, 0, strlen($folder)-1), "/");
  $parent = substr($folder, 0, $countI+1);
?>
  <tr class="bg<?php echo($countJ); ?>" onmouseover="Mover(this);" onmouseout="Mout(this, <?php echo($countJ); ?>);">
    <td colspan="8">
<?php
  echo("<a href=\"file.php\">/</a>");
  $countJ = ++$countJ % 2;
?>
    </td>
  </tr>
  <tr class="bg<?php echo($countJ); ?>" onmouseover="Mover(this);" onmouseout="Mout(this, <?php echo($countJ); ?>);">
    <td colspan="8">
<?php
  echo("<a href=\"file.php?folder=$parent\">..</a>\n");
  $countJ = ++$countJ %2;
?>
    </td>
  </tr>
<?php
}

// list dir list
for ($countI=0; $countI<count($dir_list); $countI++, $countJ = ++$countJ % 2) {
?>
  <tr class="bg<?php echo($countJ); ?>" onmouseover="Mover(this)" onmouseout="Mout(this, <?php echo($countJ); ?>)">
    <td width="10px" class="button">
      <input type="checkbox" disabled="disabled" />
    </td>
    <td width="20px" class="button">
      <img src="./images/folder.gif" alt="folder" />
    </td>
    <td width="*">
<?php
  echo("<a href=\"file.php?folder=$folder$dir_list[$countI]/\">$dir_list[$countI]</a>\n");
?>
    </td>
    <td width="100px" class="button">
      &nbsp;
    </td>
    <td width="60px" class="button">
      <button class="button2" disabled="disabled">DOWNLOAD</button>
    </td>
    <td width="60px" class="button">
      <button class="button2" onclick="FDelFolder('<?php echo("$folder"); ?>', '<?php echo("$dir_list[$countI]"); ?>');">DELETE</button>
    </td>
    <td width="60px" class="button">
      <button class="button2" onclick="FRename('<?php echo("$folder"); ?>', '<?php echo("$dir_list[$countI]"); ?>');">RENAME</button>
    </td>
    <td width="60px" class="button">
      <button class="button2" disabled="disabled">EDIT</button>
    </td>
  </tr>
<?php
}

// list file list
for ($countI=0; $countI<count($file_list); $countI++, $countJ = ++$countJ % 2) {
?>
  <tr class="bg<?php echo($countJ); ?>" onmouseover="Mover(this);" onmouseout="Mout(this, <?php echo($countJ); ?>);">
    <td width="10px" class="button">
      <input type="checkbox" />
    </td>
    <td width="20px" class="button">
      <img src="./images/file.gif" alt="file" />
    </td>
    <td width="*">
<?php
// if ()
?>
      <a href="showfile.php?folder=<?php echo($folder); ?>&filename=<?php echo("$file_list[$countI]"); ?>">
<?php
  echo("$file_list[$countI]\n");
?>
      </a>
    </td>
    <td width="100px" class="button">
<?php
  echo(filesize($target.$file_list[$countI]));
?>
      bytes    </td>
    <td width="60px" class="button">
      <button class="button2" onClick="FDownFile('<?php echo("$folder"); ?>', '<?php echo($file_list[$countI]); ?>');">DOWNLOAD</button>
    </td>
    <td width="60px" class="button">
      <button class="button2" onClick="FDelFile('<?php echo("$folder"); ?>', '<?php echo("$file_list[$countI]"); ?>');">DELETE</button>
    </td>
    <td width="60px" class="button">
      <button class="button2" onclick="FRename('<?php echo("$folder"); ?>', '<?php echo("$file_list[$countI]"); ?>');">RENAME</button>
    </td>
     <td width="60px" class="button">
      <button class="button2" disabled="disabled">EDIT</button>
    </td>
  </tr>
<?php
}

$dir->close();
?>
  <tr>
    <td colspan="6">
      Free Space: <?php echo(diskfreespace($target)); ?> Byte
    </td>
  </tr>
  <tr>
    <td colspan="6">
      <a href="mailto:caesar@pluto.iecs.fcu.edu.tw?subject=bug">Bug Report</a>
    </td>
  </tr>
  <tr>
    <td colspan="6">
      <a href="http://creativecommons.org/licenses/by-nd-nc/1.0/"><img src="./images/somerights.gif" alt="Creative Commons License" width="88" height="31" border="0" /></a>
    </td>
  </tr>
</table>
</form>

</body>

</html>

<?php
  $log="FOLDER\nUser: ".$_SERVER["REMOTE_ADDR"]."\nFolder: ".$folder."\nTime: ".date("Y/m/d H:i:s")."\n";
  $logfile=@fopen("./logfile.txt", "a");
  @fputs($logfile, $log);
  @fclose($logfile);
?>
