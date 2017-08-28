<?php

namespace Application\Models;

class Chat extends Base\BaseModel
{

    protected $table = 'chat';

    public function __construct()
    {
        parent::__construct();
    }

    public function getLastChats()
    {
        return self::$db->select($this->table, ['[>]account' =>
                    [$this->table . ".senderId" => "id"], '[>]avatar' =>
                    ['account.avatarId' => 'id']], [$this->table . '.id',
                    $this->table . '.senderId', $this->table . '.messageText',
                    $this->table . '.creationTimestamp',
                    'avatar.image', 'account.name', 'account.avatarId'], ["ORDER" => [$this->table . ".creationTimestamp" => "DESC"], "LIMIT" => 30]);
    }

    /**
     * 
     * @param array $data
     * @return boolean
     */
    public function messageSend(array $data)
    {
        if ($this->saveActivity($data['senderId'])) {
            return self::$db->insert($this->table, $data) ? true : false;
        }
        return false;
    }

}
