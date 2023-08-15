<?php

declare(strict_types=1);

include("../includes/header.php");

$columns = ['Fruit Name', 'Stock', 'Stockman', 'Date added', "Action"];

try {
	$conn = $pdo->open();

	$query = "SELECT f.fruit_id, f.fruit_name, f.instock, f.date_created, un.unit_name, us.first_name, us.last_name
				FROM `fruits` f 
				LEFT JOIN `units` un 
				ON f.unit_id=un.unit_id
				LEFT JOIN `users` us 
				ON un.created_by=us.user_id";

	$fruits = $conn->prepare($query);
	$fruits->execute();
} catch (\Throwable $th) {
	var_dump($th);
} finally {
	$pdo->close();
}
?>

<main>
	<section class="w-auto">
		<table class="table-auto border-2 border-collapse rounded-md">
			<caption>
				<div class="flex mb-4 gap-2">
					<a href="add-fruit">
						<svg class="w-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
						</svg>
					</a>
					<h1 class="header-1 | ">Fruits</h1>
				</div>
			</caption>
			<thead>
				<tr>
					<?php
					foreach ($columns as $column) :
					?>
						<th class="border-2 px-2 py-1"><?= $column; ?></th>
					<?php
					endforeach;
					?>
				</tr>
			</thead>

			<tbody>
				<?php
				if ($fruits) :
					foreach ($fruits as $fruit) :
				?>
						<tr>
							<td class="border-2 px-2 py-1"><?= ucfirst($fruit['fruit_name']) ?></td>
							<td class="border-2 px-2 py-1"><?= $fruit['instock'] . ' ' . $fruit['unit_name']  ?></td>
							<td class="border-2 px-2 py-1"><?= $fruit['first_name'] . ' ' .  $fruit['last_name'] ?></td>
							<td class="border-2 px-2 py-1"><?= $fruit['date_created'] ?></td>
							<td class="border-2 px-2 py-1">
								<div class="flex">
									<a href="update-fruit?fruit_id=<?= $fruit['fruit_id'] ?>">
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
											<path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
										</svg>
									</a>
									<a href="delete-fruit?fruit_id=">
										<svg xmlns=" http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
											<path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
										</svg>
									</a>
								</div>
							</td>
						</tr>
					<?php
					endforeach;
				else :
					?>
					<tr>
						<td class="border-2 px-2 py-1">There are no fruits!?</td>
					</tr>
				<?php
				endif;
				?>
			</tbody>
		</table>
	</section>
</main>

<?php
include("../includes/footer.php")
?>