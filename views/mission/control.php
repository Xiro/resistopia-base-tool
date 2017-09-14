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
            <table class="table table-bordered mission-table">
                <thead>
                <tr>
                    <th class="name">Name</th>
                    <th class="name">Type</th>
                    <th class="started">Started</th>
                    <th class="call-sign">Call Sign</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($operation->activeMissions as $mission): ?>
                    <tr>
                        <th class="name"><?= $mission->name ?></th>
                        <th class="name"><?= $mission->missionType->name ?></th>
                        <th class="started"><?= $mission->started ?></th>
                        <th class="call-sign"><?= implode(" - ", $mission->getCallSigns()) ?></th>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>

    </div>
</div>