<?php
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $exclude array */

use app\helpers\Html;
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
<?php /** @var $model \app\models\AccessRight */ ?>
<?php foreach ($dataProvider->getModels() as $model): ?>
    <tr class="ui-sortable-handle" data-key="<?= $model->id ?>">
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
                <?php if (!in_array("action-update", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::pencil(),
                        ['access-right/update', 'id' => $model->id]
                    ) ?>
                <?php endif; ?>
            </td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>
</tbody>