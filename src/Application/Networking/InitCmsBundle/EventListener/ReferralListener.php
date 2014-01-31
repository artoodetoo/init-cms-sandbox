<?php
/**
 * This file is part of the init_cms_sandbox package.
 *
 * (c) artoodetoo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Networking\InitCmsBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Application\Networking\InitCmsBundle\Entity\User;

/**
 * This service helps to save partner referral code for new registered user
 * It should be registered as:
 *
 *   sandbox_init_cms.request_listener:
 *       class: Application\Networking\InitCmsBundle\EventListener\ReferralListener
 *       arguments: [ @service_container ]
 *       tags:
 *           - { name: kernel.event_listener,   event: kernel.request, method: onKernelRequest }
 *           - { name: doctrine.event_listener, event: prePersist }
 *
 * @author artoodetoo
 */
class ReferralListener
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Instantiate listener. Inject container to access services
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Intercept all HTTP requests, and keep track referral
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if ($request->query->has('_ref')) {
            // It should be done for guests only
            $securityContext = $this->container->get('security.context');
            $isLoggedIn = ($securityContext->getToken() && 
               ($securityContext->isGranted('IS_AUTHENTICATED_FULLY') || 
                $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')));
            if (!$isLoggedIn) {
                $code = $request->query->get('_ref');
                $session = $this->container->get('session');
                $session->set('_ref', $code);
            }
        }
    }

    /**
     * Intercept all ORM prePersist events, and store referral if applicable
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof User) {
            $session = $this->container->get('session');
            if ($session->has('_ref')) {
                $entity->setFollowRef($session->get('_ref'));
            }
        }
    }
}