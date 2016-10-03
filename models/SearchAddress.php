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
    public static function tableSearchRequestName()
    {
        return 'search_requests';
    }

    /**
     * @return string название таблицы
     */
    public static function tableSearchRequestCountName()
    {
        return 'search_requests_count';
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
    public function selectSearchRequests($limit = 1)
    {
        $result = \Yii::$app->db->createCommand('SELECT t1.*, t2.`count` FROM ' . $this->tableSearchRequestName() . ' as t1'
                                                . ' LEFT JOIN ' . $this->tableSearchRequestCountName() . ' as t2 USING(`kladr_code`)'
                                                . ' ORDER BY t1.id DESC LIMIT :limit')
                                ->bindValue(':limit', $limit)
                                ->queryAll();

        return $result;
    }

    /**
     * найти запись в таблице поисковых запросов по id записи
     *
     * @param $id
     *
     * @return array|bool
     */
    public function getSearchRequestById($id)
    {
        if (!$id || !is_numeric($id)) {
            return false;
        }

        return \Yii::$app->db->createCommand('SELECT * FROM ' . $this->tableSearchRequestName() . ' WHERE id = :id LIMIT 1')
                             ->bindValue(':id', $id)
                             ->queryOne();

    }

    /**
     * Вставить запись в таблицу
     *
     * @param array $data
     *
     * @return bool
     * @internal param bool|string $request
     *
     */
    public function insertRecords(array $data = [])
    {
        if (empty($data['fullName']) || empty($data['id'])) {
            return false;
        }

        \Yii::$app->db->createCommand()->
        insert($this->tableSearchRequestName(), [
            'request'    => $data['fullName'],
            'kladr_code' => $data['id'],
        ])->execute();
    }

    /**
     * Вставить запись в таблицу
     *
     * @param string $request
     * @param array  $responce
     *
     * @return bool
     * @internal param array $data
     *
     * @internal param bool|string $request
     */
    public function insertRecordsTransaction($request = '', array $responce = [])
    {
        if (empty($responce['fullName']) || empty($responce['id']) || empty($request)) {
            return false;
        }

        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();

        try {
            $connection->createCommand()->insert($this->tableSearchRequestName(), [
                'request'    => $request,
                'responce'   => $responce['fullName'],
                'kladr_code' => $responce['id'],
            ])->execute();

            $connection->createCommand('INSERT INTO ' . $this->tableSearchRequestCountName() . '(`kladr_code`, `count`) VALUES(:kladr_code, :count)  ON DUPLICATE KEY UPDATE count = count + 1')
                       ->bindValue(':kladr_code', $responce['id'])
                       ->bindValue(':count', 1)
                       ->execute();

            $transaction->commit();

            return true;
        } catch (CDbException$e) {
            $transaction->rollBack();

            return false;
        }
    }
}