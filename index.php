<?php
error_reporting(E_ALL & ~E_NOTICE);

session_start();

include "config.php";
include "router.php";

include "includes/core.php";
include "includes/controls.php";
include "includes/db.php";
include "includes/util.php";
include "includes/filter.php";

include "models/global.php";

# Booting Up
init();
