<?php

style('bplog', 'bplog');
script('bplog', 'bplog');

?>

<div id='left'>
   <h3>New Checkpoint</h3>

   <form action="<?php p($_['url']); ?>" method="post">

      <div>
         <label for='systole'>Systole:</label>
         <input type='text' placeholder='Systole' name='systole' value='' />
      </div>

      <div>
         <label for='diastole'>Diastole:</label>
         <input type='text' placeholder='Diastole' name='diastole' value='' />
      </div>

      <div>
         <label for='pulse'>Pulse:</label>
         <input type='text' placeholder='Pulse' name='pulse' value='' />
      </div>
      <input type='submit' id='submit' value='Add' />
   </form>

</div>

<div id='mid'>
   <h3>Checkpoints</h3>

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
             <tr>
                <td class='id-col'>
                    <a href="#" class='log-delete' title="<?php p('Delete Record'); ?>">
                        <span class="icon icon-delete" data-id="<?php p($log->getId()); ?>">&nbsp;&nbsp;&nbsp;</span>
                    </a>
                </td>
                <td class='date-col'><?php p($log->getTimestamp()); ?></td>
                <td><?php p($log->getSystole()); ?></td>
                <td><?php p($log->getDiastole()); ?></td>
                <td><?php p($log->getPulse()); ?></td>
             </tr>
         <?php } ?>
      </tbody>
   </table>

</div>

<?php print_unescaped($this->inc('settings')); ?>
<?php if ($_['settings']['stats'] !== '0') print_unescaped($this->inc('stats')); ?>
