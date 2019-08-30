<?php


namespace app\commands;

use app\models\MedicineCheckup;
use app\models\Staff;
use mate\Resource\CsvResource;
use mate\Resource\CsvRowResource;
use Yii;
use yii\console\Controller;

class MedicineMigrateController extends Controller
{

    public function actionMigrateA38()
    {
        $csvPath = __DIR__ . '/../web/A38.csv';
        echo "Reading $csvPath\n";
        $csv = new CsvResource($csvPath, [
//            'fileOptions' => [
//                'objectEncoding' => [
//                    'from' => 'latin-1',
//                    'to' => 'UTF-8'
//                ]
//            ]
        ]);

        $total = $csv->count();
        $success = 0;
        $errors = 0;

        foreach ($csv as $i => $csvRow) {
            $checkup = new MedicineCheckup();

            // author rpn

            /** @var Staff $author */
            $author = Staff::find()->where(['like', 'rpn', (int) $csvRow->get('Erfasser')])->one();
            if(!$author) {
                echo "Row $i: ERROR: Author not found: "  . (int) $csvRow->get('Erfasser') . "\n";
                $errors++;
                continue;
            } else {
                $checkup->author_rpn = $author->sid;
            }

            // patient rpn

            $patientRpn = $this->findPatientRpn($csvRow);

            if(!$patientRpn) {
                echo "Row $i: ERROR: Patient not found: "  . $csvRow->get('Vorname') . $csvRow->get('Nachname') . "\n";
                $errors++;
                continue;
            } else {
                $checkup->patient_rpn = $patientRpn;
            }

            // data

            $checkup->nutrition = 'Unauffällig';
            $checkup->psyche = 'Unauffällig';
            $checkup->breathing = 'Unauffällig';
            $checkup->drug_use = '';

            $breathing = $csvRow->get('Atmung');
            $checkup->breathing = empty($breathing) || $breathing == 'Unauffällig' ? 'Unauffällig' : 'Auffällig';
            $checkup->pupils = $csvRow->get('Pupillen') ? $csvRow->get('Pupillen') : 'Normal';

            $pupils = $csvRow->get('Pupillen');
            switch ($pupils) {
                case 'weit':
                    $checkup->pupils = 'Erweitert';break;
                case 'eng':
                    $checkup->pupils = 'Eng';break;
                case 'normal':
                default:
                    $checkup->pupils = 'Normal';break;
            }

            $checkup->pulse = $csvRow->get('Puls');
            $checkup->temperature = (double) str_replace(',', '.', $csvRow->get('Temperatur'));

            $bloodPressure = explode('/', $csvRow->get('Blutdruck'));
            if(count($bloodPressure) == 2) {
                $checkup->blood_pressure_systolic = $bloodPressure[0];
                $checkup->blood_pressure_diastolic = $bloodPressure[1];
            }

            $checkup->complexion = mb_convert_encoding($csvRow->get('Hautbild'), 'UTF-8');
            $checkup->vaccinations = mb_convert_encoding($csvRow->get('Impfungen'), 'UTF-8');
            $checkup->conditions = mb_convert_encoding($csvRow->get('Vorerkrankungen / bekannte Infektionen / Allergien'), 'UTF-8');
            $checkup->other = mb_convert_encoding($csvRow->get('Sonstige Informationen'), 'UTF-8');
            $checkup->impairment = mb_convert_encoding($csvRow->get('Verletzungen'), 'UTF-8');

            if($checkup->save()) {
                $success++;
            } else {
                echo "Row $i: ERROR saving checkup model: " . print_r($checkup->errors, true) . "\n";
            }

        }

        echo "\n";
        echo "Success: $success\n";
        echo "Errors: $errors\n";
        echo "Total: $total\n";
    }

    protected function findPatientRpn(CsvRowResource $csvRow)
    {
        $forename = $csvRow->get('Vorname');
        $surname = $csvRow->get('Name');
        $birthday = $csvRow->get('Geburtsdatum');

        $patientRpn = false;

        $patientWheres = [
            'initials' => ['like', 'rpn', substr($forename, 0, 1) . substr($surname, 0, 1)],
            'birthday' => ['like', 'date_of_birth', date('-m-d', strtotime($birthday))],
            'forename' => ['forename' => $forename],
            'surname' => ['surname' => $forename],
        ];

        foreach ($patientWheres as $name1 => $patientWhere1) {
//                $exclude1 = [$name1];
            $query1 = Staff::find()->where($patientWhere1);
            if($query1->count() == 1) {
                $patientRpn = $query1->one()->rpn;
                return $patientRpn;
            }
            foreach ($patientWheres as $name2 => $patientWhere2) {
                $query2 = clone($query1);
                $query2->andWhere($patientWhere2);
                if($query2->count() == 1) {
                    $patientRpn = $query2->one()->rpn;
                    return $patientRpn;
                }
//                foreach ($patientWheres as $name3 => $patientWhere3) {
//                    $query3 = clone($query2);
//                    $query3->andWhere($patientWhere3);
//                    if($query3->count() == 1) {
//                        $patientRpn = $query3->one()->rpn;
//                        return $patientRpn;
//                    }
//                    foreach ($patientWheres as $name4 => $patientWhere4) {
//                        $query4 = clone($query3);
//                        $query4->andWhere($patientWhere4);
//                        if($query4->count() == 1) {
//                            $patientRpn = $query4->one()->rpn;
//                            return $patientRpn;
//                        }
//                    }
//                }
            }
        }
        return $patientRpn;
    }

}