<?php

namespace Application\Models;

use Sse\Event;

class ActiveUsersEvent extends Base\BaseEvent implements Event
{

    public function update()
    {
        $account = new Account();
        return json_encode($account->getActiveUserList());
    }

}