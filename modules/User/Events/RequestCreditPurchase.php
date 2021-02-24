<?php
namespace Modules\User\Events;

use Illuminate\Queue\SerializesModels;

class  RequestCreditPurchase
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
