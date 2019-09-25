<?php
session_start();
if ($_GET["act"]=="logoff") {
	session_destroy();
	header("Location: ../../index.php");
	exit();
}
?>