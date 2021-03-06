<?php

use app\models\AccessCategory;
use app\components\Access;

/* @var $this yii\web\View */
/* @var $form \yii\bootstrap\ActiveForm */
/* @var $model \yii\db\ActiveRecord */
/* @var $rightsField string */
/* @var $accessList int */

$rightsField = isset($rightsField) ? $rightsField : 'accessRightsSelect';
$selectedRights = array_flip($model->$rightsField);

/** @var AccessCategory[] $accessCategories */
$accessCategories = AccessCategory::find()->orderBy('order')->all();
?>
<div class="access-rights-checkboxes">
    <div class="row">
        <?php
        $reflect = new ReflectionClass($model);
        $checkboxName = $reflect->getShortName() . "[$rightsField][]";
        $colCount = 0;
        ?>
        <?php foreach ($accessCategories as $accessCategory): ?>
        <?php
        $accessOptions = [];
        foreach ($accessCategory->accessRights as $accessRight) {
            if (Access::to($accessRight->key)) {
                $accessOptions[] = $accessRight;
            }
        }
        if (count($accessOptions) === 0) {
            continue;
        }
        ?>
        <?php if ($colCount === 3): ?>
    </div>
    <div class="row">
        <?php $colCount = 0 ?>
        <?php endif; ?>
        <?php $colCount++ ?>
        <div class="col-sm-6 col-md-4 checkbox-group">
            <div class="form-group">
                <h3 class="checkbox">
                    <label style="font-size: 24px">
                        <input type="checkbox" class="group-control-checkbox">
                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                        <?= $accessCategory->name ?>
                    </label>
                </h3>
            </div>
            <div class="form-group">
                <?php foreach ($accessOptions as $accessRight): ?>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"
                                   name="<?= $checkboxName ?>"
                                   value="<?= $accessRight->id ?>"
                                <?= isset($selectedRights[$accessRight->id]) ? 'checked' : '' ?>
                            >
                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                            <?= $accessRight->name ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>