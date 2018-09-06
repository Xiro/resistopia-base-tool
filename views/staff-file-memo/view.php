<?php

use app\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\StaffFileMemo */

$this->title = 'File Memo of ' . $model->rpn;
$this->params['breadcrumbs'][] = ['label' => 'Staff File Memos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-file-memo-view container-fluid">

    <h1>
        <?= Html::encode($this->title) ?>
        <span class="pull-right">
        <?= Html::a(
            'Update',
            ['update', 'id' => $model->id],
            ['class' => 'btn btn-primary']
        ) ?>
        <?= Html::a(
            'Delete',
            ['confirm-delete', 'id' => $model->id],
            ['class' => 'btn btn-danger ajax-dialog', "data-size" => "sm"]
        ) ?>
        </span>
    </h1>

    <?php
    $memoInfo = [];
    $memoInfo["Staff"] = Html::staffLabel($model->staff);
    $memoInfo["Created"] = date("d.m.Y H:i", strtotime($model->created));

    $memoInfo["Author"] = Html::staffLabel($model->author);
    $memoInfo["Updated"] = date("d.m.Y H:i", strtotime($model->updated));

    $memoInfo["Security Level"] = $model->access_right_id ? $model->accessRight->name : '';
    $memoInfo[""] = "";
    ?>
    <div class="model-details row file-memo-info">
        <?php foreach ($memoInfo as $label => $value): ?>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-sm-6 detail-label">
                        <?= $label ?>
                    </div>
                    <div class="col-sm-6 detail-value">
                        <?= $value ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <h3><?= $model->title ?></h3>
    <p><?= nl2br($model->file_memo); ?></p>

</div>
