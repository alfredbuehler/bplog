<?php
style('bplog', 'bplog');
script('bplog', 'bplog');
?>

<div id='app-content'>
	<div id='left'>
		<h3>New Checkpoint</h3>
		<?php print_unescaped($this->inc('form')); ?>
	</div>
	<div id='mid'>
		<h3>Checkpoints</h3>
		<?php print_unescaped($this->inc('table')); ?>
	</div>
	<?php /* if ($_['settings']['stats'] !== '0') */ print_unescaped($this->inc('stats')); ?>
	<?php print_unescaped($this->inc('settings')); ?>
</div> <!-- app-content -->
