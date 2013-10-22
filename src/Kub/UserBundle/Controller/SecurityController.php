<?php
// src/Sdz/UserBundle/Controller/SecurityController.php;
namespace Kub\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request ;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use FOS\UserBundle\Controller\SecurityController as BaseController;

class SecurityController extends BaseController
{
	public function loginAction(Request $request)
	{
		if ($this->container->get("security.context")->isGranted("ROLE_USER")) {
			return new RedirectResponse($this->container->get('router')->generate("home_homepage", array(), UrlGeneratorInterface::ABSOLUTE_PATH), 302);
		}

		return parent::loginAction($request);
	}

	/**
	 * On modifie la façon dont est choisie la vue lors du rendu du formulaire de connexion
	 */
	protected function renderLogin(array $data)
	{
		// Sur la page du formulaire de connexion, on utilise la vue classique "login"
		// Cette vue hérite du layout et ne peut donc Ãªtre utilisée qu'individuellement
		if ($this->container->get('request')->attributes->get('_route') == 'fos_user_security_login') {
			$view = 'login';
		} else {
		// Mais sinon, il s'agit du formulaire de connexion intégré au menu, on utilise la vue "login_content"
		// car il ne faut pas hériter du layout !
			$view = 'login_content';
		}
		
		$template = sprintf('FOSUserBundle:Security:%s.html.%s', $view, $this->container->getParameter('fos_user.template.engine'));
		return $this->container->get('templating')->renderResponse($template, $data);
	}
}
