<h2 class="display-4 text-center pb-3">Downloads</h2>

<section>
<table class="table">
	<thead class="thead-light">
		<tr>
			<th style="width: 20%">Datum</th>
			<th style="width: 20%">Uur</th>
			<th style="width: 40%">Ingediend / opgemaakt door</th>
			<th style="width: 20%">Document</th>
		</tr>
	</thead>
	</tbody>
	<?php foreach(array_reverse($folderData) as $fileData): ?>
		<tr>
			<td><?php echo $fileData[0]; ?></td>
			<td><?php echo $fileData[1]; ?></td>
			<?php if (count($fileData) <= 4) : ?>
			<td></td>
			<td><a href="<?php echo base_url('docs/'. $fileData[3]) ?>"><?php echo $fileData[2]; ?></a></td>
			<?php else: ?>
			<td><?php echo $fileData[2]; ?></td>
			<td><a href="<?php echo base_url('docs/'. $fileData[4]) ?>"><?php echo $fileData[3]; ?></a></td>
			<?php endif; ?>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
</section>
