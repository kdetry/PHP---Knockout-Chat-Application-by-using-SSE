<?php

namespace Application\Models;

use Application\Models\Avatar;

class Account extends Base\BaseModel
{

    protected $table = 'account';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 
     * @param array $data
     * @return integer|boolean
     */
    public function saveUser(array $data)
    {
        $avatar = new Avatar();
        if (self::$db->select($avatar->getTable(), ['id'], ['id' => $data['avatarId']]) !== false) {
            $returnValue = self::$db->insert($this->table, $data) ? self::$db->id() : false;
            if ($returnValue !== false) {
                $this->saveActivity($returnValue);
            }
            return $returnValue;
        }
        return false;
    }

    public function getActiveUserList()
    {
        /*
          self::$db->debug()->select($this->table, ['[>]activity' => [$this->table . '.id' => 'senderId']],
          //['[>]activity' => [$this->table.'.id' => 'senderId'], '[>]'.$avatar->getTable() => [$this->table.'.avatarid' => 'id']],
          //[$this->table.'.id', $this->table.'.name', $this->table.'.avatarId', $avatar->getTable().'.id', $avatar->getTable().'.image', 'activity.senderId', 'activity.creationTimeStamp'],
          [$this->table . '.id', 'activity.senderId', "activity.creationTimestamp"], ['GROUP' => $this->table . '.id',"activity.creationTimestamp[>]" => date('Y-m-d H:i:s', time() - 15 * 60)]);
         * */
        return self::$db->query('SELECT "account"."id","account"."name","account"."avatarId","avatar"."image",'
                        . '"activity"."senderId","activity"."creationTimestamp" FROM "account" LEFT '
                        . 'JOIN "activity" ON "account"."id" = "activity"."senderId" '
                        . 'LEFT JOIN "avatar" ON "account"."avatarId" = "avatar"."id" WHERE datetime("activity"."creationTimestamp", '
                        . '"localtime") > "' . date('Y-m-d H:i:s', time() - 15 * 60)
                        . '" GROUP BY "account"."id"')->fetchAll(\PDO::FETCH_ASSOC);
    }

}
