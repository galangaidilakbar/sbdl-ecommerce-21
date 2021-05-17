<?php
// create function to load icom Website
// please put this function inside head to work properly
function load_icon()
{
  echo <<<EOT
  <link rel="apple-touch-icon" sizes="180x180" href="../imgs/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../imgs/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../imgs/favicon-16x16.png">
  <link rel="manifest" href="../imgs/site.webmanifest">
  EOT;
}
