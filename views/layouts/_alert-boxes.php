<?php
use mate\yii\widgets\AlertBoxes;
?>
<?= AlertBoxes::htmlFromFlashMessages([], [
    'data' => [
        'target' => '#alert-boxes-wrapper'
    ]
]) ?>
<div id="alert-boxes-wrapper" class="content-center">
    <div class="alert-boxes"></div>
</div>