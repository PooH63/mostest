<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class SearchAddress extends ActiveRecord
{
    /**
     * Выбираем подключение к нужной базе для этой модели
     *
     * @return null|object
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return \Yii::$app->db;
    }

    /**
     * @return string название таблицы
     */
    public static function tableName()
    {
        return 'search_requests';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [];
    }

    /**
     * Получить записи из табюлицы
     *
     * @param int $limit
     *
     * @return array
     */
    public function selectRecords($limit = 1)
    {
        $result = \Yii::$app->db->createCommand('SELECT * FROM ' . $this->tableName() . ' ORDER BY id DESC LIMIT :limit')
                                ->bindValue(':limit', $limit)
                                ->queryAll();
        return $result;
    }

    /**
     * Вставить запись в таблицу
     *
     * @param bool|string $request
     */
    public function insertRecords($request = '')
    {
        if (!empty($request)) {
            \Yii::$app->db->createCommand()->
            insert($this->tableName(), [
                'request' => $request,
            ])->execute();
        }
    }
}