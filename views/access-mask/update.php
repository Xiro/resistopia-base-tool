<?php

use app\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\forms\AccessMaskForm */

$this->title = 'Update Access Mask';
$this->params['breadcrumbs'][] = ['label' => 'Access Masks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="access-mask-update">
    <div class="container">
        <h1>
            <?= Html::encode($this->title) ?>

            <div class="pull-right">
                <div class="animated-label" style="width: 200px; position: relative; top: -24px">
                    <div class="form-group">
                        <?php
                        /** @var \app\models\AccessMask[] $templates */
                        $templates = \app\models\AccessMask::find()->where(['!=', 'id', $model->id])->all();
                        $selectData = \yii\helpers\ArrayHelper::map(
                            $templates,
                            function ($template) use ($model) {
                                return Url::to(['access-mask/update', 'id' => $model->id, 'templateId' => $template->id]);
                            },
                            'name'
                        );
                        echo \kartik\select2\Select2::widget([
                            'showToggleAll' => false,
                            'name'          => 'templates',
                            'data'          => $selectData,
                            'options'       => [
                                'placeholder' => '',
                                'class'       => 'form-control',
                                'onchange'    => 'location = this.value;',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]);
                        ?>
                        <label for="template" style="font-size: 14px; ">Load Template</label>
                    </div>
                </div>
            </div>
        </h1>

        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>