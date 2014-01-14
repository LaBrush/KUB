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
        $attr    = isset($options['mapping']) ? array_search('slug', $options['mapping']) : 0 ;
        	!$attr ? $attr = 'slug' : 0 ;
        $slug    = $request->attributes->get($attr);

		// On récupère l'entité correspondante
		$projet = $this->repository->findOneOrNullBySlug($slug);

		if (null === $projet && false === $configuration->isOptional()) {
            throw new NotFoundHttpException(sprintf('%s object not found for "%s" slug', $this->class, $slug));
        }

		if($projet)
		{
			$request->attributes->set($configuration->getName(), $projet);
			return true;
		}
	}

}