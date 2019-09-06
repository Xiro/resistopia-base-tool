<?php

use yii\helpers\Url;
use app\models\search\StaffSearch;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model app\models\forms\MissionForm */
/* @var $form \yii\bootstrap\ActiveForm */
?>
<?php
$searchModel = new StaffSearch();
$dataProvider = $searchModel->searchMissionForm([], $model->id);
$dataProvider->pagination->setPageSize(5);
?>
<?= $this->render('../staff/_table-form', [
    'selectableDataProvider' => $dataProvider,
    'selectedDataProvider'   => new ActiveDataProvider([
        'query' => $model->getStaff()->limit(5),
    ]),
    'form'                   => $form,
    'model'                  => $model,
    'searchUrl'              => Url::to(['staff/search-mission-form', 'missionId' => $model->id]),
    'searchModel'            => $searchModel,
    'exclude'                => ['team'],
    'actionEnableValidators' => $searchModel->getMissionActionEnableValidators(),

]) ?>