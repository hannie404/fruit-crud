<?php

declare(strict_types=1);

include("../includes/header.php");

$fruit_name = '';
$instock = '';
$unit_id = 0;

if (isset($_POST['submit'])) {
	// validate & sanitize
	$fruit_name = $_POST['fruit_name'] ? $_POST['fruit_name'] : '';
	$instock = $_POST['instock'] ? $_POST['instock'] : '';
	$unit_id
		= $_POST['unit_id'] ? $_POST['unit_id'] : 0;

	try {
		$conn = $pdo->open();

		$query = "INSERT INTO `fruits` (fruit_name ,instock, unit_id, created_by, updated_by) 
		VALUES (:fruit_name ,:instock, :unit_id, :created_by, :updated_by)";

		$param = [
			"fruit_name" => $fruit_name,
			"instock" => $instock,
			"unit_id" => $unit_id,
			"created_by" => 1,
			"updated_by" => 1,
		];

		$fruit = $conn->prepare($query);
		$fruit->execute($param);

		if (!$fruit) {
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
		<h1 class="header-1">Add a fruit</h1>
		<a href="./" class="bg-pink-700 px-2 py-1 rounded block ms-auto | hover:bg-pink-500 focus:outline-none focus:ring-2 focus::ring-inset focus:ring-pink-300 ">Back</a>
	</div>
	<form class="" action=" <?= $_SERVER['PHP_SELF']; ?>" method="POST">
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
						<option value="<?= $unit['unit_id']; ?>" <?= $unit['unit_id'] ===  $unit_id ? 'selected' : null; ?>><?= ucfirst($unit['unit_name']); ?></option>
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