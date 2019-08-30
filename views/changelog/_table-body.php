<?php
/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

/* @var $exclude array */

use app\helpers\Html;
use mate\yii\widgets\Glyphicon;
use yii\helpers\Inflector;

$pagination = $dataProvider->pagination;
if ($pagination) {
    $pagination->totalCount = $dataProvider->totalCount;
}
$exclude = !isset($exclude) ? array() : $exclude;
?>
<tbody data-page="<?= $pagination ? $pagination->page + 1 : 0 ?>"
       data-page-size="<?= $pagination ? $pagination->pageSize : 0 ?>"
       data-page-count="<?= $pagination ? $pagination->pageCount : 0 ?>">
<?php /** @var $model \app\models\Changelog */ ?>
<?php foreach ($dataProvider->getModels() as $model): ?>
    <tr data-key="<?= $model->id ?>">
        <?php if (!in_array("object", $exclude)): ?>
            <td class="object">
                <?= $model->object ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("data", $exclude)): ?>
            <td class="data">
                <?= $this->render('_changes-table', [
                    'model' => $model
                ]) ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("user", $exclude)): ?>
            <td class="user">
                <?php
                if ($model->user_id && $model->user && $model->user->sid) {
                    echo $model->user->staff->sid . " ";
                    echo Html::a(
                        Glyphicon::eye_open(),
                        ['staff/view', 'id' => $model->user->staff->sid],
                        ["class" => "ajax-dialog", "data-size" => "lg"]
                    );
                }
                ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("created", $exclude)): ?>
            <td class="created">
                <?= date('d.m.Y H:i:s', strtotime($model->created)) ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("actions", $exclude)): ?>
            <td class="actions">
                <?php if (!in_array("action-view", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::eye_open(),
                        ['changelog/view', 'id' => $model->id],
                        ["class" => "ajax-dialog", "data-size" => "lg"]
                    ) ?>
                <?php endif; ?>
            </td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>
</tbody>