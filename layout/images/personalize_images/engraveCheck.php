<?php

if (isset($_GET['id']) && isset($_GET['font']) && isset($_GET['engrave']) && isset($_GET['engrave_2'])){
  echo $_GET['id'];
  echo $_GET['font'];
  echo $_GET['engrave'];
  echo $_GET['engrave_2'];
}
