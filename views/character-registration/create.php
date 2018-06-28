<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $staff app\models\forms\StaffForm */
/* @var $background app\models\StaffBackground */

$this->title = 'Create your character';
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'staff'      => $staff,
            'background' => $background
        ]) ?>

    </div>
</div>