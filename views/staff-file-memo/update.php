<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StaffFileMemo */

$this->title = 'Update Staff File Memo';
$this->params['breadcrumbs'][] = ['label' => 'Staff File Memos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="staff-file-memo-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>