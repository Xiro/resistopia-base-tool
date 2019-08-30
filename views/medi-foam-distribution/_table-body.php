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
<?php /** @var $model \app\models\MediFoamDistribution */ ?>
<?php foreach ($dataProvider->getModels() as $model): ?>
    <tr data-key="<?= $model->id ?>">
        <?php if (!in_array("recipient_sid", $exclude)): ?>
            <td class="recipient_sid">
                <?= Html::staffLabel($model->recipient) ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("mk1_issued", $exclude)): ?>
            <td class="mk1_issued">
                <?= $model->mk1_issued ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("mk1_returned", $exclude)): ?>
            <td class="mk1_returned">
                <?= $model->mk1_returned ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("issued_by_sid", $exclude)): ?>
            <td class="issued_by_sid">
                <?= Html::staffLabel($model->issuedBy) ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("created", $exclude)): ?>
            <td class="created">
                <?= $model->created ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("actions", $exclude)): ?>
            <td class="actions">
                <?php if (!in_array("action-view", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::eye_open(),
                        ['medi-foam-distribution/view', 'id' => $model->id],
                        ["class" => "ajax-dialog", "data-size" => "lg"]
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-update", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::pencil(),
                        ['medi-foam-distribution/update', 'id' => $model->id]
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-delete", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::trash(),
                        ['medi-foam-distribution/confirm-delete', 'id' => $model->id],
                        ["class" => "ajax-dialog", "data-size" => "sm"]
                    ) ?>
                <?php endif; ?>
            </td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>
</tbody>