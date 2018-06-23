<?php

use yii\helpers\Html;
use app\models\AccessCategory;
use app\models\AccessBit;

/* @var $this yii\web\View */
/* @var $form \yii\bootstrap\ActiveForm */
/* @var $model \yii\db\ActiveRecord */
/* @var $bitsField string */
/* @var $accessKey int */

$bitsField = isset($bitsField) ? $bitsField : 'accessBits';
$accessKey = isset($accessKey) ? $accessKey : ($model->hasAttribute('access_key') ? $model->access_key : 0);

/** @var AccessCategory[] $accessCategories */
$accessCategories = AccessCategory::find()->orderBy('order')->all();

?>
<div class="access-bits-checkboxes row">
    <?php
    $reflect = new ReflectionClass($model);
    $checkboxName =  $reflect->getShortName() . "[$bitsField][]";
    ?>
    <?php foreach ($accessCategories as $accessCategory): ?>
        <div class="col-sm-6 col-md-4 checkbox-group">
            <div class="form-group">
                <h3 class="checkbox">
                    <label style="font-size: 24px">
                        <input type="checkbox" class="group-control-checkbox">
                        <?= $accessCategory->name ?>
                    </label>
                </h3>
            </div>
            <div class="form-group">
            <?php foreach($accessCategory->accessBits as $accessBit): ?>
                <div class="checkbox">
                    <label>
                        <input type="checkbox"
                               name="<?= $checkboxName ?>"
                               value="<?= $accessBit->bit_pos ?>"
                               <?= $accessBit->isInKey($accessKey) ? 'checked' : '' ?>
                        >
                        <?= $accessBit->name ?>
                    </label>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>