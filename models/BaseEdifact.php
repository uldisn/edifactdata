<?php

/**
 * This is the model base class for the table "edifact".
 *
 * Columns in table "edifact" available as properties of the model:
 * @property string $id
 * @property string $terminal
 * @property string $prep_datetime
 * @property string $message_ref_number
 * @property string $filename
 * @property string $message
 * @property string $create_datetime
 *
 * There are no model relations.
 */
abstract class BaseEdifact extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'edifact';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('create_datetime', 'required'),
                array('terminal, prep_datetime, message_ref_number, filename, message', 'default', 'setOnEmpty' => true, 'value' => null),
                array('terminal', 'length', 'max' => 5),
                array('message_ref_number, filename', 'length', 'max' => 20),
                array('prep_datetime, message', 'safe'),
                array('id, terminal, prep_datetime, message_ref_number, filename, message, create_datetime', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->terminal;
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
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('EdifactDataModule.model', 'ID'),
            'terminal' => Yii::t('EdifactDataModule.model', 'Terminal'),
            'prep_datetime' => Yii::t('EdifactDataModule.model', 'Prep Datetime'),
            'message_ref_number' => Yii::t('EdifactDataModule.model', 'Message Ref Number'),
            'filename' => Yii::t('EdifactDataModule.model', 'Filename'),
            'message' => Yii::t('EdifactDataModule.model', 'Message'),
            'create_datetime' => Yii::t('EdifactDataModule.model', 'Create Datetime'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.terminal', $this->terminal, true);
        $criteria->compare('t.prep_datetime', $this->prep_datetime, true);
        $criteria->compare('t.message_ref_number', $this->message_ref_number, true);
        $criteria->compare('t.filename', $this->filename, true);
        $criteria->compare('t.message', $this->message, true);
        $criteria->compare('t.create_datetime', $this->create_datetime, true);


        return $criteria;

    }

}
