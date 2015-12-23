<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $full_name
 * @property string $position
 * @property string $date
 * @property string $salary
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['full_name', 'position', 'date'], 'required'],
            [['date'], 'safe'],
            [['salary'], 'number'],
            [['full_name'], 'string', 'max' => 255],
            [['position'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'full_name' => 'Full Name',
            'position' => 'Position',
            'date' => 'Date',
            'salary' => 'Salary',
        ];
    }
}
