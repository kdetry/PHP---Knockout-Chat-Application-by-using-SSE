<?php

namespace Application\Models;

class Avatar extends Base\BaseModel
{
    protected $table = 'avatar';

    public function getAvatarList()
    {
        return self::$db->select($this->table, ['id', 'image']);
    }

}
