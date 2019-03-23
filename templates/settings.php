
<div id="app-settings">
	<div id="app-settings-header">
		<button class="settings-button" data-apps-slide-toggle="#app-settings-content">
			<?php p($l->t('Settings'));?>
		</button>
	</div>

	<div id="app-settings-content">
		<fieldset class="settings-fieldset">
			<ul class="settings-fieldset-interior">

				<li class="settings-fieldset-interior-item">
					<input type='checkbox' class='checkbox' id="newontop" />
					<label class="checkbox" for="newontop">
						<?php p($l->t('New on top')); ?>
					</label>
				</li>

				<li class="settings-fieldset-interior-item">
					<input type="checkbox" class='checkbox' id="stats" />
					<label class="checkbox" for="stats">
						<?php p($l->t('Statistics')); ?>
					</label>
				</li>

				<li class="settings-fieldset-interior-item">
					<button
						id ='log-export'
						href="export?requesttoken=<?php p(urlencode($_['requesttoken'])) ?>">
						<?php p($l->t('Export'));?>
					</button>
					<input
						type="hidden"
						name="requesttoken"
						value="<?php p($_['requesttoken']) ?>"
						id="requesttoken">
					</input>
				</li>

			</ul>
		</fieldset>
	</div>
</div>

<input type="hidden" id="newontopcurr" value="<?php p($_['settings']['newontop']); ?>" />
<input type="hidden" id="statscurr" value="<?php p($_['settings']['stats']); ?>" />
