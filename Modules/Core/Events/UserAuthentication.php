<?php

namespace Modules\Core\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;

class UserAuthentication
{
    use SerializesModels;

    /**
     * this attribute indicates if the transaction
     * was login or logout
     *
     * @author BaRaa
     * @var
     */
    public $logTransaction;
    /**
     * authenticated user
     *
     * @author BaRaa
     *
     */
    public $authUser;

    /**
     * Create a new event instance.
     *
     * @param $logTransaction
     * @param null $authUser
     */
    public function __construct($logTransaction, $authUser = null)
    {
        $this->logTransaction = $logTransaction;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
