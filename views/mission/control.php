<?php

/* @var $this yii\web\View */
/* @var $missions \app\models\Mission[] */
/* @var $operations \app\models\Operation[] */

$this->title = 'Mission Control';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="mission-control" xmlns="http://www.w3.org/1999/html">
    <div class="container">

        <?php foreach ($operations as $operation): ?>
            <h3 style="margin-bottom: 0; padding-left: 9px"><?= $operation->name ?></h3>
            <?= $this->render("_mission-table", [
                "missionModels" => $operation->missions,
                "exclude" => ["mission-status", "description", "debrief-comment", "ended"],
            ]); ?>
        <?php endforeach; ?>

    </div>
</div>