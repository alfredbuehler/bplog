
<?php

function statrow($item) {
    echo "<td>", p($item['sys']), "</td>";
    echo "<td>", p($item['dia']), "</td>";
    echo "<td>", p($item['hrt']), "</td>";
}

?>

<div id='right'>
	<h3>Statistics</h3>

	<table>
		<thead>
			<tr>
				<th></th>
				<th>Systole</th>
				<th>Diastole</th>
				<th>Pulse</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td class="label">Avg</td>
                <?php statrow($_['stdata']['avg']); ?>
			</tr>

			<tr>
				<td class="label">Min</td>
                <?php statrow($_['stdata']['min']); ?>
			</tr>

			<tr>
				<td class="label">Max</td>
                <?php statrow($_['stdata']['max']); ?>
			</tr>

		</tbody>
	</table>

</div>
