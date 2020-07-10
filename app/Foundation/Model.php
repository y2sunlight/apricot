<?php
namespace App\Foundation;

use ORM;
use App\Exceptions\OptimissticLockException;
use App\Exceptions\ApplicationException;

/**
 * モデル
 */
class Model
{
    /**
     * 最新の更新結果(insert/update/delete)
     * @var bool
     */
    private $success = false;

    /**
     * テーブル名の取得
     * @return string
     */
    public function tableName():string
    {
        return snake_case(get_short_class_name($this));
    }

    /**
     * テーブルの取得
     * @return \ORM
     */
    public function for_table():ORM
    {
        return ORM::for_table(snake_case(get_short_class_name($this)));
    }

    /**
     * 全件検索
     * @return array|\IdiormResultSet
     */
    public function findAll()
    {
        return $this->for_table()->find_many();
    }

    /**
     * 主キー検索
     * @param int $id
     * @return \ORM|false returna single instance of the ORM class, or false if norows were returned.
     */
    public function findOne(int $id)
    {
        return $this->for_table()->find_one($id);
    }

    /**
     * 新規作成
     * @return \ORM
     */
    public function create(array $inputs=null):ORM
    {
        return $this->for_table()->create($inputs);
    }

    /**
     * 新規保存
     * @param array $inputs
     * @return \ORM
     */
    public function insert(array $inputs):ORM
    {
        $row = $this->for_table()->create($inputs);
        $row->set_expr('created_at', "datetime('now','localtime')");
        $row->set_expr('updated_at', "datetime('now','localtime')");
        $this->success = $row->save();
        return $row;
    }

    /**
     * データ更新
     * @param mixed $id
     * @param array $inputs
     * @return \ORM
     */
    public function update($id, array $inputs):ORM
    {
        // ApricotではSQLite3.0.8以上の使用を前提としており、トランザクション分離レベルはデフォルト値がDEFERREDです。
        // DEFERRED は最初の読み取り時に共有ロックが掛かります(SQLiteのロックはデータベースロックです)。
        // 従って、version_no読み取り後はトランザクション終了まで他の更新は発生しません。
        // NOTE: 他のデータベースの場合は、ここで行ロックを取得してレコードの検索を行います(select for update)
        $row = $this->for_table()->find_one($id);
        if ($row===false)
        {
            throw new ApplicationException(__('messages.error.db.update'));
        }

        // 楽観的ロックの検証
        if ($row->version_no != $inputs['version_no'])
        {
            throw new OptimissticLockException();
        }

        // データ更新
        $row->set($inputs);
        $row->set_expr('updated_at', "datetime('now','localtime')");
        $row->set_expr('version_no', "version_no+1");
        $this->success = $row->save();
        return $row;
    }

    /**
     * データ削除
     * @param mixed $id
     * @return \ORM
     */
    public function delete($id):ORM
    {
        $row = $this->for_table()->find_one($id);
        if ($row===false)
        {
            throw new ApplicationException(__('messages.error.db.delete'));
        }
        $this->success = $row->delete();
        return $row;
    }

    /**
     * 最新の更新結果の取得(insert/update/delete)
     * @return bool
     */
    public function isSuccess():bool
    {
        return $this->success;
    }
}