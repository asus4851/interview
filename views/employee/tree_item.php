<?php
/**
 * @var \app\models\Employee $item
 * @var int $deep
 */
?>

<li class="list-group-item" style="padding-left: <?= ($deep-1)*10 + 15 ?>px;">(<?= $deep ?>)<?= $item->full_name?> <div class="text-right"><?=$item->position ?></div></li>