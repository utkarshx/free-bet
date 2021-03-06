<?php

namespace FreeBet\Bundle\UIBundle\Menu;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Jb\Bundle\ConfigKnpMenuBundle\Event\ConfigureMenuEvent;

/**
 * Description of ConfigurationListener
 *
 * @author jobou
 */
class ConfigurationListener
{
    /**
     * Security context
     *
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    protected $securityContext;

    /**
     * Constructor
     *
     * @param \Symfony\Component\Security\Core\SecurityContextInterface $securityContext
     */
    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * Executed on maestro.navigation.menu_configure event
     *
     * @param \Jb\Bundle\ConfigKnpMenuBundle\Event\ConfigureMenuEvent $eventMenu
     */
    public function configureMenu(ConfigureMenuEvent $eventMenu)
    {
        $menu = $eventMenu->getMenu();

        if ($menu->getName() != 'main') {
            return;
        }

        if ($this->securityContext->getToken() === null || !$this->securityContext->isGranted('ROLE_MANAGER')) {
            $menu->removeChild('organization_item');
        }
    }
}
