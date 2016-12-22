<?php
if (!is_null($style)) {
  switch ($style) {
    case "0":
    case "1":
      break;
    default:
      $style = 0;
  }

  setcookie("view_style", $style);
} else {
  $style = $view_style;
}
?>
