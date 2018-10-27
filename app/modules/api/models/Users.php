<?php

namespace app\modules\api\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property int $crdate
 * @property int $tstamp
 * @property int $deleted
 *
 * @property XUserGroup[] $xUserGroups
 */
class Users extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['crdate', 'tstamp', 'deleted'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['crdate', 'tstamp'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['tstamp'],
                ]
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'crdate' => 'Crdate',
            'tstamp' => 'Tstamp',
            'deleted' => 'Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getXUserGroups()
    {
        return $this->hasMany(XUserGroup::className(), ['user_id' => 'id']);
    }
}
