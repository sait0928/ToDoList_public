<label>期日：
  <select name="year" class="js-changeYear">
    <?php foreach(range($current_year,$current_year+4) as $year): ?>
    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
    <?php endforeach ?>
  </select>
  <select name="month" class="js-changeMonth">
    <?php foreach(range(1,12) as $month): ?>
    <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
    <?php endforeach; ?>
  </select>
  <select name="day" class="js-changeDay">
    <?php foreach(range(1,31) as $day): ?>
    <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
    <?php endforeach; ?>
  </select>
</label>