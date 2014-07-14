<?php

/**
 * This is the model class for table "{{option}}".
 *
 * The followings are the available columns in table '{{option}}':
 * @property string $id
 * @property string $api_id
 * @property integer $is_passthrough
 * @property string $url_passthrough
 * @property string $name
 * @property integer $delay
 * @property integer $http_code
 * @property integer $is_json
 * @property string $reponse_data
 * @property integer $order
 *
 * The followings are the available model relations:
 * @property Api[] $apis
 * @property Api $api
 */
class Option extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Option the static model class
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
		return '{{option}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('is_passthrough, delay, http_code, is_json, order', 'numerical', 'integerOnly'=>true),
			array('api_id', 'length', 'max'=>20),
			array('name, url_passthrough', 'length', 'max'=>255),
			array('reponse_data', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, api_id, name, is_passthrough, url_passthrough, delay, http_code, is_json, reponse_data, order', 'safe', 'on'=>'search'),
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
			'apis' => array(self::HAS_MANY, 'Api', 'current_option'),
			'api' => array(self::BELONGS_TO, 'Api', 'api_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'api_id' => 'Api',
			'name' => 'Name',
			'is_passthrough' => 'Is Passthrough',
			'url_passthrough' => 'Url Passthrough',
			'delay' => 'Delay',
			'http_code' => 'Http Code',
			'is_json' => 'Is Json',
			'reponse_data' => 'Reponse Data',
			'order' => 'Order',
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
		$criteria->compare('api_id',$this->api_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('delay',$this->delay);
		$criteria->compare('http_code',$this->http_code);
		$criteria->compare('is_json',$this->is_json);
		$criteria->compare('reponse_data',$this->reponse_data,true);
		$criteria->compare('order',$this->order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}