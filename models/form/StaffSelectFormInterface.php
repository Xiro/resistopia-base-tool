<?php


namespace app\models\form;


use app\models\Staff;

interface StaffSelectFormInterface
{

    /**
     * @return Staff[]
     */
    public function getCombinedStaffModels();

}