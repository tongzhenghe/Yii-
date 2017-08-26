<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $consignee
 * @property string $town
 * @property string $district
 * @property string $place
 * @property string $detailedAddress
 * @property string $tel
 * @property integer $status
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['consignee','detailedAddress','tel','town','district','place'], 'required'],
            [['status'], 'integer'],
            [['consignee', 'town', 'district', 'place','detailedAddress'], 'string', 'max' => 100],
            [['tel'], 'string', 'max' => 11],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'consignee' => 'Consignee',
            'town' => 'Town',
            'district' => 'District',
            'place' => 'Place',
            'detailedAddress' => 'Detailed Address',
            'tel' => 'Tel',
            'status' => 'Status',
        ];
    }
}
