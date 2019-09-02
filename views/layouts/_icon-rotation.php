<?php
use app\helpers\Html;

echo Html::img(
    Yii::getAlias('@web/img/resistance_logo_500.png'),
    [
        'class' => 'rotate',
        'speed' => 1500,
        'images' => json_encode([
//            Yii::getAlias('@web/img/resistance_logo_500.png'),
//            Yii::getAlias('@web/img/kat_stab_500.png'),
//            Yii::getAlias('@web/img/kat_medizin_500.png'),
//            Yii::getAlias('@web/img/kat_sicherheit_500.png'),
//            Yii::getAlias('@web/img/kat_technik_500.png'),
//            Yii::getAlias('@web/img/kat_kaempfer_500.png'),
//            Yii::getAlias('@web/img/kat_forschung_500.png'),
//            Yii::getAlias('@web/img/kat_coh_500.png'),
            Yii::getAlias('@web/img/phoenix_500.png'),
        ]),
    ]
);