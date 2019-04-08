
<div id='app-settings'>
	<div id='app-settings-header'>
		<button class='settings-button' data-apps-slide-toggle='#app-settings-content'>
			<?php p($l->t('Settings'));?>
		</button>
	</div>

	<div id='app-settings-content'>
		<fieldset class='settings-fieldset'>
			<ul class='settings-fieldset-interior'>

				<li class='settings-fieldset-interior-item'>
					<input type='checkbox' class='checkbox setting' id='newontop' />
					<label class='checkbox' for='newontop'>
						<?php p($l->t('New on top')); ?>
					</label>
				</li>

				<li class='settings-fieldset-interior-item'>
					<input type='checkbox' class='checkbox setting'  id='stats' />
					<label class='checkbox' for='stats'>
						<?php p($l->t('Statistics')); ?>
					</label>
				</li>

				<li class='settings-fieldset-interior-item'>
					<button
						id ='log-export'
						href="export?requesttoken=<?php p(urlencode($_['requesttoken'])) ?>">
						<?php p($l->t('Export'));?>
					</button>
					<input
						type='hidden'
						name='requesttoken'
						value="<?php p($_['requesttoken']) ?>"
						id='requesttoken'>
					</input>
				</li>

				<li class='settings-fieldset-interior-item'>
					<button id ='log-import'>
						<?php p($l->t('Import'));?>
					</button>
					<input type='checkbox' class='checkbox' id='bp-clear' />
					<label class='checkbox' for='bp-clear'>
						<?php p($l->t('Clear log')); ?>
					</label>
				</li>

			</ul>
		</fieldset>
	</div>
</div>

<form id='upload' name='upload' class='hidden'>
	<input type='file' accept='text/csv' id='bp-import' name='bp-import' />
</form>

<input type='hidden' id='newontopcurr' value="<?php p($_['settings']['newontop']); ?>" />
<input type='hidden' id='statscurr' value="<?php p($_['settings']['stats']); ?>" />
