<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use app\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h3><?= Html::encode($this->title) ?></h3>

    <p style="font-size: 20px; margin-bottom: 15px">
        <?= nl2br(Html::encode($message)) ?>
    </p>

    <h1>
        Ein Fehler ist aufgetreten, aber das liegt nicht an Ihnen!
    </h1>
    <p>
        Bitte sammeln Sie alle Informationen, die zur Beseitigung des Fehlers hilfreich sind. Hierzu gehören:
        <ul>
            <li>Was haben Sie angeklickt, bevor der Fehler aufgetreten ist?</li>
            <li>Was haben Sie unmittelbar davor gemacht?</li>
            <li>Haben Sie ein Formular ausgefüllt? Wenn ja, mit welchen Daten?</li>
            <li>Tritt dieser Fehler immer auf, wenn Sie die Aktion nochmal ausführen?</li>
        </ul>
        Melden Sie sich danach mit einer detaillierten Beschreibung des Fehlers im CIC bei Nico Schulte.<br>
        <br>
        Vielen Dank.
    </p>

</div>
