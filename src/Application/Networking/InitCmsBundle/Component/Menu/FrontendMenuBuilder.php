<?php

namespace Application\Networking\InitCmsBundle\Component\Menu;

use Symfony\Component\HttpFoundation\Request;
use Networking\InitCmsBundle\Entity\MenuItem as Menu;
use Networking\InitCmsBundle\Component\Menu\FrontendMenuBuilder as BaseMenuBuilder;

/**
 * Class FrontendMenuBuilder
 * @package Application\Networking\InitCmsBundle\Component\Menu
 */
class FrontendMenuBuilder extends BaseMenuBuilder
{
    /**
     * Used to create nodes for the language navigation in the front- and backend
     *
     * @param $menu
     * @param array $languages
     * @param $currentLanguage
     * @param string $route
     */
    public function createDropdownLangMenu(
        &$menu,
        array $languages,
        $currentLanguage,
        $route = 'networking_init_change_language'
    )
    {
        $this->addDivider($menu, true);

        $shortLabel = '--';
        foreach ($languages as $language) {
            if ($language['locale'] == $currentLanguage) {
                $shortLabel = $language['short_label'];
                break;
            }
        }

        $dropdown = $this->createDropdownMenuItem(
            $menu,
            $shortLabel,
            true,
            array('icon' => 'caret')
        );

        foreach ($languages as $language) {
            $node = $dropdown->addChild(
                "{$language['label']} ({$language['locale']})",
                array('uri' => $this->router->generate($route, array('locale' => $language['locale'])))
            );

            if ($language['locale'] == $currentLanguage) {
                $node->setCurrent(true);
            }
        }
    }

    /**
     * Creates the login and change language navigation for the right side of the top frontend navigation
     *
     * @param string $classes
     * @internal param \Symfony\Component\HttpFoundation\Request $request
     * @internal param $languages
     * @return \Knp\Menu\ItemInterface
     */
    public function createLoginMenu($classes = 'nav pull-right')
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', $classes);

        if ($this->isLoggedIn) {
            $user = $this->securityContext->getToken()->getUser();
            $username = htmlspecialchars($user->getUsername(), ENT_QUOTES, 'UTF-8');
            $hash = $user->getHash();

            $menu->addChild('profile', array(
                'route' => 'sonata_user_profile_show',
                'label' => "<img src=\"http://www.gravatar.com/avatar/{$hash}\" width=\"20\" style=\"max-width: 20px ; height: 20px;\" />&nbsp;{$username}",
                'extras' => array('safe_label' => true))
             );
            $menu->addChild($this->translator->trans('logout'), array('route' => 'fos_user_security_logout'));
        } else {
            $menu->addChild($this->translator->trans('login'), array('route' => 'fos_user_security_login'));
            $menu->addChild(
                $this->translator->trans('register'),
                array('route' => 'fos_user_registration_register')
            );
        }


        return $menu;
    }

}
