<?php

namespace Kub\MessageBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\MessageBundle\Provider\ProviderInterface;

use FOS\MessageBundle\Controller\MessageController as BaseController ;

class MessageController extends BaseController
{
	public function inboxAction()
	{
		$threads = array_merge($this->getProvider()->getInboxThreads(), $this->getProvider()->getSentThreads());

		return $this->container->get('templating')->renderResponse('FOSMessageBundle:Message:sent.html.twig', array(
            'threads' => $threads
        ));
	}
}