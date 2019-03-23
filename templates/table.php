
<table>
   <thead>
	   <tr>
		 <th class='id-col' />
		 <th class='date-col'>Date</th>
		 <th>Systole</th>
		 <th>Diastole</th>
		 <th>Pulse</th>
	  </tr>
   </thead>
   <tbody>
	  <?php foreach($_['logs'] as $log){ ?>
		  <tr data-id="<?php p($log->getId()); ?>">
			 <td class='id-col'>
				 <a href="#" class='icon icon-delete log-delete'
				 	title="<?php p('Delete Record'); ?>">&nbsp;&nbsp;&nbsp;</a>
				 <a href="#" class='icon icon-edit log-edit'
				 	title="<?php p('Edit Record'); ?>">&nbsp;&nbsp;&nbsp;</a>
			 </td>
			 <td class='date-col'><?php p($log->getTimestamp()); ?></td>
			 <td><?php p($log->getSystole()); ?></td>
			 <td><?php p($log->getDiastole()); ?></td>
			 <td><?php p($log->getPulse()); ?></td>
		  </tr>
	  <?php } ?>
   </tbody>
</table>
