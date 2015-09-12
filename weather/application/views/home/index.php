<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>
<div id="day-count">Day <?= $day['Day'] ?><div id="avg">Avg <?= $day['AvT'] ?>°F</div>
 <div id="high" class="homeTemp"><?= $day['MxT'] ?>°F</div></div><div id="low"><?= $day['MnT'] ?>°F</div>
