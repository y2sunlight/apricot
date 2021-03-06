<?php
namespace App\Foundation;

use ORM;
use App\Exceptions\OptimissticLockException;
use App\Exceptions\ApplicationException;

/**
 * Model class
 */
class Model
{
    /**
     * @var bool Last SQL(insert/update/delete) execution result.
     */
    private $successful = false;

    /**
     * Gets the table name
     * @return string
     */
    public function tableName():string
    {
        return snake_case(get_short_class_name($this));
    }

    /**
     * Returns the ORM instance.
     *
     * @return \ORM
     */
    public function forTable():ORM
    {
        return ORM::forTable($this->tableName());
    }

    /**
     * Finds all records.
     *
     * @return array|\IdiormResultSet
     */
    public function findAll()
    {
        return $this->forTable()->findMany();
    }

    /**
     * Finds a record by the primary key.
     *
     * @param int $id
     * @return \ORM|false return a single instance of the ORM class, or false if no rows were returned.
     */
    public function findOne(int $id)
    {
        return $this->forTable()->findOne($id);
    }

    /**
     * Creates a new, empty instance of the model class.
     *
     * @param array $inputs
     * @return \ORM
     */
    public function create(array $inputs=null):ORM
    {
        return $this->forTable()->create($inputs);
    }

    /**
     * Inserts the input field into the database.
     *
     * @param array $inputs
     * @return \ORM
     */
    public function insert(array $inputs):ORM
    {
        $now = $this->now();
        $row = $this->forTable()->create($inputs);
        $row->set('created_at', $now);
        $row->set('updated_at', $now);
        $this->successful = $row->save();
        return $row;
    }

    /**
     * Update the database with the input fields.
     *
     * @param mixed $id
     * @param array $inputs
     * @return \ORM
     */
    public function update($id, array $inputs):ORM
    {
        $row = $this->forTable()->findOne($id);
        if ($row===false)
        {
            // Apricot assumes use of SQLite 3.0.8 or higher, so the default value of transaction isolation level is DEFERRED.
            // At DEFERRED level, a shared lock (database lock) is acquired on the first read.
            // Therefore, after reading version_no, other updates do not occur until the transaction ends.
            // Note: For other databases, you can get a row lock here to find the record (that is, "select for update").
            throw new ApplicationException(__('messages.error.db.update'));
        }

        // Optimistic lock verification
        if ($row->version_no != $inputs['version_no'])
        {
            throw new OptimissticLockException();
        }

        // Saving the input fields
        $row->set($inputs);
        $row->set('updated_at', $this->now());
        $row->set_expr('version_no', "version_no+1");
        $this->successful = $row->save();
        return $row;
    }

    /**
     * Deletes the record with the primary key.
     *
     * @param mixed $id
     * @return \ORM
     */
    public function delete($id):ORM
    {
        $row = $this->forTable()->findOne($id);
        if ($row===false)
        {
            throw new ApplicationException(__('messages.error.db.delete'));
        }
        $this->successful = $row->delete();
        return $row;
    }

    /**
     * Gets the last SQL execution result.
     *
     * @return bool
     */
    public function isSuccessful():bool
    {
        return $this->successful;
    }

    /**
     * Gets the current date and time.
     * @return string
     */
    private function now()
    {
        return date("Y-m-d H:i:s");
    }
}