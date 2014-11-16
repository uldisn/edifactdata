<?php

/**
 * This is the model base class for the table "ecpr_container_procesing".
 *
 * Columns in table "ecpr_container_procesing" available as properties of the model:
 * @property string $ecpr_id
 * @property string $ecpr_start_ecnt_id
 * @property string $ecpr_end_ecnt_id
 *
 * Relations of table "ecpr_container_procesing" available as properties of the model:
 * @property EcntContainer[] $ecntContainers
 * @property EcntContainer $ecprStartEcnt
 * @property EcntContainer $ecprEndEcnt
 */
abstract class BaseEcprContainerProcesing extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'ecpr_container_procesing';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('ecpr_start_ecnt_id', 'required'),
                array('ecpr_end_ecnt_id', 'default', 'setOnEmpty' => true, 'value' => null),
                array('ecpr_start_ecnt_id, ecpr_end_ecnt_id', 'length', 'max' => 10),
                array('ecpr_id, ecpr_start_ecnt_id, ecpr_end_ecnt_id', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->ecpr_start_ecnt_id;
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(), array(
                'savedRelated' => array(
                    'class' => '\GtcSaveRelationsBehavior'
                )
            )
        );
    }

    public function relations()
    {
        return array_merge(
            parent::relations(), array(
                'ecntContainers' => array(self::HAS_MANY, 'EcntContainer', 'ecnt_ecpr_id'),
                'ecprStartEcnt' => array(self::BELONGS_TO, 'EcntContainer', 'ecpr_start_ecnt_id'),
                'ecprEndEcnt' => array(self::BELONGS_TO, 'EcntContainer', 'ecpr_end_ecnt_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'ecpr_id' => Yii::t('EdifactDataModule.model', 'Ecpr'),
            'ecpr_start_ecnt_id' => Yii::t('EdifactDataModule.model', 'Ecpr Start Ecnt'),
            'ecpr_end_ecnt_id' => Yii::t('EdifactDataModule.model', 'Ecpr End Ecnt'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.ecpr_id', $this->ecpr_id, true);
        $criteria->compare('t.ecpr_start_ecnt_id', $this->ecpr_start_ecnt_id);
        $criteria->compare('t.ecpr_end_ecnt_id', $this->ecpr_end_ecnt_id);


        return $criteria;

    }

}
