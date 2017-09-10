<?php

use yii\db\Migration;

class m170910_135309_default_contents extends Migration
{
    public function safeUp()
    {
        $this->execute("INSERT INTO `category` (`name`) VALUES
            ('Fighter'),
            ('Base Science'),
            ('Base Medicine'),
            ('Base Security'),
            ('Base Technicians'),
            ('CIC'),
            ('Council of Humanity'),
            ('T.A.O.'),
            ('GDA'),
            ('TacRec'),
            ('other')
        ;");
        $this->execute("INSERT INTO `speciality` (`name`) VALUES
            ('CombatMedic'),
            ('FieldMedic'),
            ('CombatRadiooperator'),
            ('FieldRadiooperator'),
            ('CombatTechnician'),
            ('FieldTechnician'),
            ('CombatReseacher'),
            ('FieldReseacher'),
            ('CombatGuard'),
            ('FieldGuard'),
            ('none')
        ;");
        $this->execute("INSERT INTO `rank` (`name`) VALUES 
            ('Civilian'),
            ('Volunteer'),
            ('Recruit'),
            ('Resistance Fighter Mark 1'),
            ('Resistance Fighter Mark 2'),
            ('Resistance Fighter Mark 3'),
            ('Specialist Mark 1'),
            ('Specialist Mark 2'),
            ('Specialist Mark 3'),
            ('Corporal Mark 1'),
            ('Corporal Mark 2'),
            ('Corporal Mark 3'),
            ('Corporal Specialist Mark 1'),
            ('Corporal Specialist Mark 2'),
            ('Corporal Specialist Mark 3'),
            ('Sergeant Mark 1'),
            ('Sergeant Mark 2'),
            ('Sergeant Mark 3'),
            ('Sergeant Specialist  Mark 1'),
            ('Sergeant Specialist  Mark 2'),
            ('Sergeant Specialist  Mark 3'),
            ('Master Sergeant'),
            ('Lieutenant'),
            ('First Lieutenant / Executive Officer'),
            ('Commander')
        ;");
        $this->execute("INSERT INTO `blood_type` (`name`) VALUES 
            ('0 Rh neg. Kell pos.'),
            ('0 Rh neg. Kell neg.'),
            ('0 Rh pos. Kell pos.'),
            ('0 Rh pos. Kell neg.'),
            ('A Rh neg. Kell pos.'),
            ('A Rh neg. Kell neg.'),
            ('A Rh pos. Kell pos.'),
            ('A Rh pos. Kell neg.'),
            ('B Rh neg. Kell pos.'),
            ('B Rh neg. Kell neg.'),
            ('B Rh pos. Kell pos.'),
            ('B Rh pos. Kell neg.'),
            ('AB Rh neg. Kell pos.'),
            ('AB Rh neg. Kell neg.'),
            ('AB Rh pos. Kell pos.'),
            ('AB Rh pos. Kell neg.')
        ;");
        $this->execute("INSERT INTO `eye_color` (`name`) VALUES 
            ('brown'),
            ('green'),
            ('blue'),
            ('gray'),
            ('brown-green'),
            ('blue-green'),
            ('blue-gray'),
            ('green-gray')
        ;");
        $this->execute("INSERT INTO `mission_status` (`name`) VALUES 
            ('pending'),
            ('active'),
            ('completed'),
            ('failed')
        ;");
        $this->execute("INSERT INTO `mission_type` (`name`) VALUES 
            ('scouting'),
            ('rescue'),
            ('recovery'),
            ('support'),
            ('attack')
        ;");
        $this->execute("INSERT INTO `role` (`name`) VALUES 
            ('Admin'),
            ('CIC'),
            ('Medicine'),
            ('Security')
        ;");
        $this->execute("INSERT INTO `staff_status` (`name`) VALUES 
            ('alive'),
            ('missing'),
            ('dead')
        ;");
    }

    public function safeDown()
    {
        echo "m170910_135309_default_contents cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170910_135309_default_contents cannot be reverted.\n";

        return false;
    }
    */
}
