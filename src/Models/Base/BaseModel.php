<?php

namespace Application\Models\Base;

use Medoo\Medoo;

class BaseModel
{

    protected static $db;

    public function __construct()
    {
        $this->getConnection();
    }

    private function getConnection()
    {
        self::$db = new Medoo([
            'database_type' => 'sqlite',
            'database_file' => ROOT . 'db.sqlite',
            'debug_mode' => true
        ]);
    }

    /**
     * Table property getter
     * @return strıng
     */
    public function getTable()
    {
        if (isset($this->table)) {
            return $this->table;
        }
        return '';
    }

    /**
     * Save Activity
     * @param integer|string $senderId
     * @return boolean
     */
    public function saveActivity($senderId)
    {
        $senderId = intval($senderId);
        return self::$db->insert('activity', ['senderId' => $senderId])? true : false;
    }

}
