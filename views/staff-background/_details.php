<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StaffBackground */

$textFields = [
    'story_before',
    'story_during',
    'story_after',
    'career',
    'characteristics',
    'personality',
    'awards',
];

$isEmpty = true;
foreach ($textFields as $textField) {
    if($model->$textField) {
        $isEmpty = false;
        break;
    }
}

if($isEmpty) {
    return null;
}

?>

<h3>
    Background
    <span class="heading-btn-group pull-right">
        <?= Html::a(
            'Update Background',
            ['staff-background/update', 'id' => $model->rpn],
            ['class' => 'btn btn-primary']
        ) ?>
        <?= Html::a(
            'Delete Background',
            ['staff-background/confirm-delete', 'id' => $model->rpn],
            ['class' => 'btn btn-danger']
        ) ?>
    </span>
</h3>

<?php foreach($textFields as $modelAttr): ?>
    <?php if($model->$modelAttr): ?>
    <h4><?= $model->getAttributeLabel($modelAttr) ?></h4>
    <?= nl2br($model->$modelAttr) ?>
    <?php endif; ?>
<?php endforeach; ?>
