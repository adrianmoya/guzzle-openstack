<?php
/**
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Openstack\Common;

/**
 * Observer to manage authentication for Openstack Clients
 */
class IdentityAuthObserver implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return array(
            'client.create_request' => 'onRequestCreate'
        );
    }    
    
    public function onRequestCreate(\Guzzle\Common\Event $event)
    {               
        $subject = $event['client'];
        $context = $event['request'];
        $username = $subject->getUsername();
        $password = $subject->getPassword();
        $token = $subject->getIdentity()->getToken($username, $password);
        $context->setHeader('X-Auth-Token', $token);
    }
}

?>
