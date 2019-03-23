
<div id='app-sidebar' class='disappear'>
	<div class='updatecontainer'>
		<h3>Edit Checkpoint</h3>
		<a id='close' class='close icon-close' href='#' alt='Close'></a>
		<form id='upd'>
			<div>
				<label for='idd'>Id:</label>
				<input type='text' placeholder='Id' id='upd_idd' name='idd' value='' disabled />
				<input type='hidden' id='upd_id' name='id' value='' />
			</div>

			<div>
				<label for='created'>Date:</label>
				<input type='text' placeholder='Date' id='upd_date' name='created' value='' required />
			</div>

			<div>
			   <label for='systole'>Systole:</label>
			   <input type='text' placeholder='Systole' id='upd_systole' name='systole' value='' />
			</div>

			<div>
			   <label for='diastole'>Diastole:</label>
			   <input type='text' placeholder='Diastole' id='upd_diastole' name='diastole' value='' />
			</div>

			<div>
			   <label for='pulse'>Pulse:</label>
			   <input type='text' placeholder='Pulse' id='upd_pulse' name='pulse' value='' />
			</div>


			<input type='submit' id='update' value='Update' />
		</form>
	</div>
</div>
