<?php
session_start();
unset($_SESSION["user"]);
session_unset();
session_destroy();
echo 0;