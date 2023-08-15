<?php

declare(strict_types=1);

require('../../config/database.php');

if (!isset($_GET['fruit_id'])) {
	header("Location: ./");
}

$err_msg = '';

$fruit_id = $_GET['fruit_id'];
$fruit_name = null;
$instock = null;
$unit_id = null;

try {
	$conn = $pdo->open();
	$query = "DELETE FROM fruits WHERE fruit_id=:fruit_id";
	$param = ["fruit_id" => $fruit_id];
	$fruit = $conn->prepare($query);
	$fruit->execute($param);

	if (!$fruit) {
		header("Location: ./");
	}
	header("Location: ./");
} catch (\Throwable $th) {
	var_dump($th);
} finally {
	$pdo->close();
}
