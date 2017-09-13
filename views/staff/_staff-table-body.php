<?php

/* @var $staffModels \app\models\Staff[] */

use yii\helpers\Html;
use app\widgets\Glyphicon;
?>

<?php foreach ($staffModels as $staff): ?>
    <tr>
        <td><?= $staff->rpn ?></td>
        <td><?= $staff->getName() ?></td>
        <td>
            <span><?= $staff->category ? $staff->category->name : "None" ?></span>
        </td>
        <td><?= $staff->speciality ? $staff->speciality->name : "None" ?></td>
        <td><?= $staff->team ? $staff->team->name : "None" ?></td>
        <td><?= $staff->staffStatus ? $staff->staffStatus->name : "None" ?></td>
        <td><?= $staff->call_sign ? $staff->call_sign : "None" ?></td>
        <td>
            <?= Html::a(
                    Glyphicon::pencil(),
                    ['staff/update', 'id' => $staff->id],
                    ["class" => "ajax-dialog"]
            ) ?>
            <?= Html::a(
                    Glyphicon::trash(),
                    ['staff/confirm-delete'],
                    ["class" => "ajax-dialog"]
            ) ?>
        </td>
    </tr>
<?php endforeach; ?>