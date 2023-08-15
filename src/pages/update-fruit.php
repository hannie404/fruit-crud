<?php

declare(strict_types=1);

include("../includes/header.php");

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
	$query = "SELECT * FROM fruits WHERE fruit_id=:fruit_id";
	$param = ["fruit_id" => $fruit_id];
	$fruit = $conn->prepare($query);
	$fruit->execute($param);
	$fruit_data = $fruit->fetch();

	if (!$fruit_data) {
		header("Location: ./");
	}

	$fruit_name = $fruit_data['fruit_name'];
	$instock = $fruit_data['instock'];
	$unit_id = $fruit_data['unit_id'];
} catch (\Throwable $th) {
	var_dump($th);
} finally {
	$pdo->close();
}

if (isset($_POST['submit'])) {
	// validate & sanitize
	$fruit_name = $_POST['fruit_name'] ? $_POST['fruit_name'] : '';
	$instock = $_POST['instock'] ? $_POST['instock'] : '';
	$unit_id
		= $_POST['unit_id'] ? $_POST['unit_id'] : 0;

	try {
		$conn = $pdo->open();

		$query = "UPDATE fruits SET fruit_name=:fruit_name, instock=:instock, unit_id=:unit_id WHERE fruit_id=:fruit_id";

		$params = [
			"fruit_name" => $fruit_name,
			"instock" => $instock,
			"unit_id" => $unit_id,
			"fruit_id" => $fruit_id
		];

		$fruit = $conn->prepare($query);
		$affectedRow = $fruit->execute($params);

		if (!$affectedRow) {
			return $err_msg = '';
		}
		header("Location: ./");
	} catch (\Throwable $th) {
		throw $th;
	} finally {
		$pdo->close();
	}
}
?>

<section class=" | bg-slate-700 max-w-md w-full p-4 rounded-md">
	<div class="flex flex-row justify-between items-center">
		<h1 class="header-1">Update a fruit</h1>
		<a href="./" class="bg-pink-700 px-2 py-1 rounded block ms-auto | hover:bg-pink-500 focus:outline-none focus:ring-2 focus::ring-inset focus:ring-pink-300 ">Back</a>
	</div>
	<form action="<?= $_SERVER['PHP_SELF'] . "?fruit_id={$fruit_id}"; ?>" method="POST">
		<div class="my-4">
			<label for="fruitName" class="form-label |">Fruit name:</label>
			<input id="firstName" type="text" class="form-control | " name="fruit_name" value="<?= $fruit_name; ?>" placeholder="Enter fruit name">
		</div>

		<div class="my-4">
			<label for="inStock" class="form-label |">In stock:</label>
			<input id="inStock" type="number" class="form-control | " name="instock" value="<?= $instock; ?>" placeholder="Enter stock amount">
		</div>

		<div class="my-4">
			<label for="unit" class="form-label |">Unit:</label>
			<select name="unit_id" id="unit" class="form-control | ">
				<?php
				try {
					$conn = $pdo->open();
					$query = "SELECT * FROM units";
					$units = $conn->prepare($query);
					$units->execute();
					foreach ($units as $unit) :
				?>
						<option value="<?= $unit['unit_id']; ?>" <?= $unit['unit_id'] ===  $unit_id ? 'selected' : ''; ?>><?= ucfirst($unit['unit_name']); ?></option>
				<?php
					endforeach;
				} catch (\Throwable $th) {
					var_dump($th);
				} finally {
					$pdo->close();
				}
				?>
			</select>
		</div>

		<button class="bg-pink-700 px-2 py-1 rounded block ms-auto | hover:bg-pink-500 focus:outline-none focus:ring-2 focus::ring-inset focus:ring-pink-300 " name="submit" type="submit">Submit</button>
	</form>
</section>

<?php
include("../includes/footer.php")
?>