<?php
switch ($style) {
  case "1":
    break;
  default:
    $style = 0;
}

echo("@import url(\"./style/file".$style.".css\");");
?>
