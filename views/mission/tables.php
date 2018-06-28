<?php

use app\helpers\Html;
use yii\data\ActiveDataProvider;
use app\widgets\Glyphicon;

/* @var $this yii\web\View */
/* @var $tables \yii\db\ActiveQuery[] */
/* @var $title string */

$this->title = $title ? $title : 'Missions';
$this->params['breadcrumbs'][] = $this->title;

?>
<?php if (!Yii::$app->request->isAjax): ?>
    <div class="mission-tables">
    <div class="container">

    <?php if ($title): ?>
        <h1>
            <?= $this->title ?>
            <span class="heading-btn-group">
                    <?= Glyphicon::refresh(['class' => 'btn-auto-reload active']) ?>
            </span>
        </h1>
    <?php endif; ?>
<?php endif; ?>
    <div class="reload-target">
        <?php $skipped = 0; ?>
        <?php foreach ($tables as $label => $query): ?>
            <?php if ($query->count() == 0) {
                $skipped++;
                continue;
            } ?>
            <h4><?= $label ?></h4>

            <div class="">
                <?= $this->render("_table", [
                    "dataProvider" => new ActiveDataProvider([
                        'query'      => $query,
                        'pagination' => false
                    ]),
                    "searchModel"  => null,
                ]) ?>
            </div>
        <?php endforeach; ?>
        <?php if ($skipped === count($tables)): ?>
            <div class="no-tables text-center">
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                        <h2>No Missions to show</h2>
                    </div>
                </div>

            </div>
        <?php endif; ?>
    </div>
<?php if (!Yii::$app->request->isAjax): ?>
    </div>
    </div>
<?php endif; ?>