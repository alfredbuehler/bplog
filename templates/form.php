
<form id='checkpoint'>

	<input type='hidden' id='id' />

	<div>
		<label for='created'>Date:</label>
		<input type='text' placeholder='Date' id='created' name='created' value='' required disabled />

		<input type='checkbox' class="checkbox" name='auto' id='auto' checked />
		<label class="checkbox" for="auto">Auto</label>
	</div>

	<div>
	   <label for='systole'>Systole:</label>
	   <input type='text' placeholder='Systole' id='systole' name='systole' value='' />
	</div>

	<div>
	   <label for='diastole'>Diastole:</label>
	   <input type='text' placeholder='Diastole' id='diastole' name='diastole' value='' />
	</div>

	<div>
	   <label for='pulse'>Pulse:</label>
	   <input type='text' placeholder='Pulse' id='pulse' name='pulse' value='' />
	</div>

	<button id='exec'>Add</button>	<button id='cancel' class='disappear' type='reset'>Cancel</button>

</form>
