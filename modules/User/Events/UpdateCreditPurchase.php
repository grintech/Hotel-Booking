<?php
namespace Modules\User\Events;

use Illuminate\Queue\SerializesModels;

class  UpdateCreditPurchase
{
    use SerializesModels;
    public $user;
    public $payment;

    public function __construct($user,$payment)
    {
        $this->user = $user;
        $this->payment = $payment;
    }
}
