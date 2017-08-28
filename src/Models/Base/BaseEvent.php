<?php

namespace Application\Models\Base;

class BaseEvent extends BaseModel
{
    protected $oldTime = 0;

    /**
     * 
     * Here's the place to check when the data needs update
     * @return boolean
     */
    public function check()
    {
        if ((time() - $this->oldTime) > 3) {
            $this->oldTime = time();
            return true;
        }
        return false;
    }

}
