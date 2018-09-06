<?php

use app\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StaffFileMemo */

$this->title = $model->rpn ? 'Add File Memo for ' . $model->staff->name : 'Add File Memo';
$this->params['breadcrumbs'][] = ['label' => 'Staff File Memos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-file-memo-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
        "model" => $model,
    ]) ?>
    </div>
</div>