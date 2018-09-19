<?php

use app\helpers\Html;
use yii\data\ActiveDataProvider;
use mate\yii\widgets\Glyphicon;

/* @var $this yii\web\View */
/* @var $tables \yii\db\ActiveQuery[] */
/* @var $title string */

$this->title = $title ? $title : 'Mission Control';
$this->params['breadcrumbs'][] = $this->title;

?>
<?php if (!Yii::$app->request->isAjax): ?>
<div class="mission-control">
    <div class="container">

        <h1>
            <?= $this->title ?>

            <span class="heading-btn-group">
                    <?= Glyphicon::refresh(['class' => 'btn-auto-reload active']) ?>
            </span>

            <span class="heading-btn-group pull-right">
            <?= Html::a(
                "<span class=\"glyphicon glyphicon-plus\"></span> " . 'Create Mission',
                ["create"],
                ["class" => "btn btn-default"]
            ); ?>
            </span>
        </h1>
        <?php endif; ?>

        <div class="reload-target">
        <?php foreach ($tables as $label => $query): ?>
            <?php if ($query->count() == 0) continue; ?>
            <h4><?= $label ?></h4>

            <div class="">
                <?= $this->render("_table", [
                    "dataProvider" => new ActiveDataProvider([
                        'query'      => $query,
                        'pagination' => false
                    ]),
                    "searchModel"  => null,
                    'exclude' => ['time_ete']
                ]) ?>
            </div>
        <?php endforeach; ?>
        </div>
        <?php if (!Yii::$app->request->isAjax): ?>

    </div>
</div>

<?php endif; ?>