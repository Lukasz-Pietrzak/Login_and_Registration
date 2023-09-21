<?php

session_start();

session_unset();

header("Location: Login-Form.php");