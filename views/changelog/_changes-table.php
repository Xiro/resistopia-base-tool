<?php

use yii\helpers\Inflector;
use mate\yii\widgets\Glyphicon;

/* @var $this yii\web\View */
/* @var $model \app\models\Changelog */

$className = "app\\models\\" . $model->object;
$data = json_decode($model->data, true);
if (class_exists($className)) {
    /** @var \yii\db\ActiveRecord $dummy */
    $dummy = new $className();
    $labels = $dummy->attributeLabels();
} else {
    $labels = [];
}
?>
<?php if($data): ?>
    <table class="changes">
        <?php foreach ($data as $attribute => $changes): ?>
            <tr>
                <th><?= isset($labels[$attribute]) ? $labels[$attribute] : Inflector::id2camel(Inflector::camel2words($attribute)) ?></th>
                <td><?= $changes[0] ? $changes[0] : 'n/a' ?></td>
                <td><?= Glyphicon::arrow_right() ?></td>
                <td><?= $changes[1] ? $changes[1] : 'n/a' ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>