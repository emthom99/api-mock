<?php

/**
 * This is the model class for table "{{history}}".
 *
 * The followings are the available columns in table '{{history}}':
 * @property string $id
 * @property string $api_id
 * @property string $url
 * @property string $name
 * @property string $ip
 * @property string $method
 * @property string $resquest
 * @property string $response
 * @property string $create_time
 *
 * The followings are the available model relations:
 * @property Api $api
 */
class History extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return History the static model class
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
		return '{{history}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('api_id', 'length', 'max'=>20),
			array('url, name, ip, method', 'length', 'max'=>255),
			array('resquest, response, create_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, api_id, url, name, ip, method, resquest, response, create_time', 'safe', 'on'=>'search'),
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
			'url' => 'Url',
			'name' => 'Name',
			'ip' => 'Ip',
			'method' => 'Method',
			'resquest' => 'Resquest',
			'response' => 'Response',
			'create_time' => 'Create Time',
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
		$criteria->compare('url',$this->url,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('method',$this->method,true);
		$criteria->compare('resquest',$this->resquest,true);
		$criteria->compare('response',$this->response,true);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}