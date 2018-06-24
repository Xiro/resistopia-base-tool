<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\search\StaffFileMemoSearch */

$this->title = 'Staff File Memos';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="staff-file-memo-index">
    <div class="container">

        <h1>
            <?= Html::encode($this->title) ?>
        </h1>

        <div class="">
            <?= $this->render("_table", [
                "dataProvider" => $dataProvider,
                "searchModel"  => $searchModel,
            ]) ?>
        </div>
    </div>
</div>