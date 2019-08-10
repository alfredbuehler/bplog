
<?php

function statrow($item, $id) {
    echo "<td>", p($item['sys']), "</td>";
    echo "<td>", p($item['dia']), "</td>";
    echo "<td>", p($item['hrt']), "</td>";
	echo "<td class='mark'><div class='mark' id='$id'>&nbsp;</div></td>";
	echo "<input type='hidden' id='inp-$id' value='", p($item['idx']), "' />";
}

?>

<div id='right'>
	<div id='stats-container'>
		<h3>Statistics</h3>

		<table>
			<thead>
				<tr>
					<th></th>
					<th>Systole</th>
					<th>Diastole</th>
					<th>Pulse</th>
					<th class='mark'/>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td class="label">Avg</td>
	                <?php statrow($_['stdata']['avg'], 'q-avg'); ?>
				</tr>

				<tr>
					<td class="label">Min</td>
	                <?php statrow($_['stdata']['min'], 'q-min'); ?>
				</tr>

				<tr>
					<td class="label">Max</td>
	                <?php statrow($_['stdata']['max'], 'q-max'); ?>
				</tr>

			</tbody>
		</table>
	</div>
</div>
