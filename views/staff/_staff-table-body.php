<?php

/* @var $staffModels \app\models\Staff[] */

use yii\helpers\Html;
use app\widgets\Glyphicon;
?>

<?php foreach ($staffModels as $staff): ?>
    <tr>
        <td class="rpn">
            <?= $staff->rpn ?>
        </td>
        <td class="name">
            <?= $staff->getName() ?>
        </td>
        <td class="category">
            <span><?= $staff->category ? $staff->category->name : "None" ?></span>
        </td>
        <td class="speciality">
            <?= $staff->speciality ? $staff->speciality->name : "None" ?>
        </td>
        <td class="team">
            <?= $staff->team ? $staff->team->name : "None" ?>
        </td>
        <td class="staff-status">
            <?= $staff->staffStatus ? $staff->staffStatus->name : "None" ?>
        </td>
        <td class="call-sign">
            <?= $staff->call_sign ? $staff->call_sign : "None" ?>
        </td>
        <td class="actions">
            <?= Html::a(
                    Glyphicon::pencil(),
                    ['staff/update', 'id' => $staff->id],
                    ["class" => "ajax-dialog"]
            ) ?>
            <?= Html::a(
                    Glyphicon::trash(),
                    ['staff/confirm-delete', 'id' => $staff->id],
                    ["class" => "ajax-dialog"]
            ) ?>
        </td>
    </tr>
<?php endforeach; ?>