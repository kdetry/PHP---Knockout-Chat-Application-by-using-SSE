<?php

namespace Application\Models;

use Sse\Event;

class MessageEvent extends Base\BaseEvent implements Event
{
    /**
     * Send data 
     * @return string
     */
    public function update()
    {
        $chat = new Chat();
        return json_encode($chat->getLastChats());
    }

}
