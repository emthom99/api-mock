<?php

/**
 * This is the model class for table "{{api}}".
 *
 * The followings are the available columns in table '{{api}}':
 * @property string $id
 * @property string $name
 * @property string $url
 * @property string $current_option
 * @property integer $validated
 *
 * The followings are the available model relations:
 * @property Option $currentOption
 * @property History[] $histories
 * @property Option[] $options
 */
class Api extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Api the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{api}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('validated', 'numerical', 'integerOnly'=>true),
			array('name, url', 'length', 'max'=>255),
			array('url','unique'),
			array('name, url','required'),
			array('current_option', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, url, current_option, validated', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'currentOption' => array(self::BELONGS_TO, 'Option', 'current_option'),
			'histories' => array(self::HAS_MANY, 'History', 'api_id'),
			'options' => array(self::HAS_MANY, 'Option', 'api_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'url' => 'Url',
			'current_option' => 'Current Option',
			'validated' => 'Validated',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('current_option',$this->current_option,true);
		$criteria->compare('validated',$this->validated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                            'pageSize'=>100,
                        ),
		));
	}
}