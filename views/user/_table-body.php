<?php
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $exclude array */

use yii\helpers\Html;
use mate\yii\widgets\Glyphicon;

$pagination = $dataProvider->pagination;
$pagination->totalCount = $dataProvider->totalCount;
$exclude = !isset($exclude) ? array() : $exclude;
?>
<tbody data-page="<?= $pagination->page + 1 ?>"
       data-page-size="<?= $pagination->pageSize ?>"
       data-page-count="<?= $pagination->pageCount ?>">
<?php /** @var $model \app\models\User */ ?>
<?php foreach ($dataProvider->getModels() as $model): ?>
    <tr data-key="<?= $model->id ?>">
        <?php if (!in_array("rpn", $exclude)): ?>
            <td class="rpn">
                <?= $model->rpn ? $model->rpn . ' (' . $model->staff->getName() . ')' : "None" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("created", $exclude)): ?>
            <td class="created">
                <?= $model->created ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("updated", $exclude)): ?>
            <td class="updated">
                <?= $model->updated ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("actions", $exclude)): ?>
            <td class="actions">
                <?php if (!in_array("action-view", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::eye_open(),
                        ['user/view', 'id' => $model->id],
                        ["class" => "ajax-dialog", "data-size" => "lg"]
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-update", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::pencil(),
                        ['user/update', 'id' => $model->id]
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-delete", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::trash(),
                        ['user/confirm-delete', 'id' => $model->id],
                        ["class" => "ajax-dialog", "data-size" => "sm"]
                    ) ?>
                <?php endif; ?>
            </td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>
</tbody>