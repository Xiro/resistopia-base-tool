<?php

/* @var $teamModels \app\models\Team[] */

use yii\helpers\Html;
use app\widgets\Glyphicon;
?>

<?php foreach ($teamModels as $team): ?>
    <tr>
        <td class="name">
            <?= $team->name ?>
        </td>
        <td class="name">
            <?= $team->getStaff()->count() ?>
        </td>
        <td class="actions">
            <?= Html::a(
                    Glyphicon::pencil(),
                    ['team/update', 'id' => $team->id],
                    ["class" => "ajax-dialog"]
            ) ?>
            <?= Html::a(
                    Glyphicon::trash(),
                    ['team/confirm-delete', 'id' => $team->id],
                    ["class" => "ajax-dialog"]
            ) ?>
        </td>
    </tr>
<?php endforeach; ?>