<?php
namespace Concrete\Core\Notification\Type;

use Concrete\Core\Notification\Subject\SubjectInterface;
use Concrete\Core\Notification\Subscription\StandardSubscription;

class NewPrivateMessageType extends Type
{

    public function createNotification(SubjectInterface $subject)
    {
        // TODO: Implement createNotification() method.
    }

    protected function createSubscription()
    {
        $subscription = new StandardSubscription('new_private_message', t('Private messages'));
        return $subscription;
    }

    public function getSubscription(SubjectInterface $subject)
    {
        return $this->createSubscription();
    }

    public function getAvailableSubscriptions()
    {
        return array($this->createSubscription());
    }





}