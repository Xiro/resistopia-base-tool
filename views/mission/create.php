<?php

use app\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\forms\MissionForm */

$this->title = 'Create Mission';
$this->params['breadcrumbs'][] = ['label' => 'Missions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mission-create">
    <div class="container">
        <h1>
            <?= Html::encode($this->title) ?>

<!--            <div class="pull-right">
                <div class="animated-label" style="width: 200px; position: relative; top: -24px">
                    <div class="form-group">
                        <?php
//                        /** @var \app\models\Mission[] $templates */
//                        $templates = \app\models\Mission::find()
//                            ->joinWith('missionStatus')
//                            ->where(['mission_status.name' => 'template'])
//                            ->all();
//                        $selectData = \yii\helpers\ArrayHelper::map(
//                            $templates,
//                            function ($template) {
//                                return Url::to(['mission/create', 'id' => $template->id]);
//                            },
//                            'name'
//                        );
//                        echo \kartik\select2\Select2::widget([
//                            'showToggleAll' => false,
//                            'name'          => 'templates',
//                            'data'          => $selectData,
//                            'options'       => [
//                                'placeholder' => '',
//                                'class'       => 'form-control',
//                                'onchange'    => 'location = this.value;',
//                            ],
//                            'pluginOptions' => [
//                                'allowClear' => true,
//                            ],
//                        ]);
                        ?>
                        <label for="template" style="font-size: 14px; ">Load Template</label>
                    </div>
                </div>
            </div>
-->
        </h1>


        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>