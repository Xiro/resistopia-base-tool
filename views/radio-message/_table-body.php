<?php
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $exclude array */

use yii\helpers\Html;
use mate\yii\widgets\Glyphicon;

$pagination = $dataProvider->pagination;
if($pagination) {
    $pagination->totalCount = $dataProvider->totalCount;
}
$exclude = !isset($exclude) ? array() : $exclude;
?>
<tbody data-page="<?= $pagination ? $pagination->page + 1 : 0 ?>"
       data-page-size="<?= $pagination ? $pagination->pageSize : 0 ?>"
       data-page-count="<?= $pagination ? $pagination->pageCount : 0 ?>">
<?php /** @var $model \app\models\RadioMessage */ ?>
<?php foreach ($dataProvider->getModels() as $model): ?>
    <tr data-key="<?= $model->id ?>">
        <?php if (!in_array("callsign", $exclude)): ?>
            <td class="callsign">
                <?= $model->callsign ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("message", $exclude)): ?>
            <td class="message">
                <?= $model->message ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("created", $exclude)): ?>
            <td class="created">
                <?= $model->created ? date('H:i', strtotime($model->created)) : "" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("actions", $exclude)): ?>
            <td class="actions">
                <?php if (!in_array("action-update", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::pencil(),
                        ['radio-message/update', 'id' => $model->id]
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-delete", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::trash(),
                        ['radio-message/confirm-delete', 'id' => $model->id],
                        ["class" => "ajax-dialog", "data-size" => "sm"]
                    ) ?>
                <?php endif; ?>
            </td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>
</tbody>