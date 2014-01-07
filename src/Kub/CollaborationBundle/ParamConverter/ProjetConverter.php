<?php

namespace Kub\CollaborationBundle\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException ;

class ProjetConverter implements ParamConverterInterface
{
	protected $class;
	protected $repository;

	public function __construct($class, $em)
	{
		$this->class = $class;
		$this->repository = $em->getRepository($class) ;
	}

	function supports(ConfigurationInterface $configuration)
	{
		return $configuration->getClass() == $this->class;
	}

	function apply(Request $request, ConfigurationInterface $configuration)
	{
		$name    = $configuration->getName();
        $options = $configuration->getOptions();
        $slug    = $request->attributes->get('slug');

		// On récupère l'entité correspondante
		$projet = $this->repository->findOneOrNullBySlug($slug);

		if (null === $projet && false === $configuration->isOptional()) {
            throw new NotFoundHttpException(sprintf('%s object not found.', $this->class));
        }

		if($projet)
		{
			$request->attributes->set($configuration->getName(), $projet);
			return true;
		}
	}

}