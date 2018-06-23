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
<?php /** @var $model \app\models\AccessBit */ ?>
<?php foreach ($dataProvider->getModels() as $model): ?>
    <tr class="ui-sortable-handle" data-key="<?= $model->bit_pos ?>">
        <?php if (!in_array("order", $exclude)): ?>
            <td class="order order-content">
                <?= $model->order; ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("name", $exclude)): ?>
            <td class="name">
                <?= $model->name ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("key", $exclude)): ?>
            <td class="key">
                <?= $model->key ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("access_category", $exclude)): ?>
            <td class="access_category">
                <?= $model->access_category_id ? $model->accessCategory->name : '' ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("comment", $exclude)): ?>
            <td class="comment">
                <?= $model->comment ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("actions", $exclude)): ?>
            <td class="actions">
                <?php /*if (!in_array("action-view", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::eye_open(),
                        ['access-bit/view', 'id' => $model->bit_pos],
                        ["class" => "ajax-dialog", "data-size" => "lg"]
                    ) ?>
                <?php endif; */ ?>
                <?php /*if (!in_array("action-update", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::pencil(),
                        ['access-bit/update', 'id' => $model->bit_pos]
                    ) ?>
                <?php endif;*/ ?>
                <?php if (!in_array("action-delete", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::trash(),
                        ['access-bit/confirm-delete', 'id' => $model->bit_pos],
                        ["class" => "ajax-dialog", "data-size" => "sm"]
                    ) ?>
                <?php endif; ?>
            </td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>
</tbody>