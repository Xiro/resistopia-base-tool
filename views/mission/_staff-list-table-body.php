<?php

/* @var $staffModels \app\models\Staff[] */
/* @var $checked bool */

$checked = !isset($checked) ? false : $checked;
use app\widgets\Glyphicon;
use yii\helpers\Html;
?>

<?php foreach ($staffModels as $staff): ?>
    <tr data-id="<?= $staff->id ?>">
        <td class="rpn">
            <?= $staff->rpn ?>
        </td>
        <td class="name">
            <?= $staff->getName() ?>
        </td>
        <td class="team">
            <?= $staff->team ? $staff->team->name : "None" ?>
        </td>
        <td class="call-sign">
            <?= $staff->call_sign ? $staff->call_sign : "None" ?>
        </td>
        <td class="actions">
            <?= Glyphicon::arrow_right(["class" => "list-btn add-staff"]) ?>
            <?= Glyphicon::remove(["class" => "assigned-btn remove-staff"]) ?>
            <?= Html::checkbox("MissionForm[staffSelect][]", $checked, [
                "value" => $staff->id,
                "class" => " staff-select-checkbox hidden"
            ]); ?>
        </td>
    </tr>
<?php endforeach; ?>