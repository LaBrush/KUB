<?php

namespace Kub\UserBundle\ParamConverter ;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface ;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface ;
use Symfony\Component\HttpFoundation\Request ;
use Doctrine\ORM\EntityManager ;

class UserParamConverter implements ParamConverterInterface 
{

	protected $class ;
	protected $repository ;

	public function __construct($class, EntityManager $em)
	{
		$this->class      = $class ;
		$this->repository = $em->getRepository($class) ;
	}

	function supports(ConfigurationInterface $configuration)
	{
		return $configuration->getClass() == $this->class ;
	}

	function apply(Request $request, ConfigurationInterface $configuration)
	{
		$eleve = $this->repository->findWithAll();
		$request->attributes->set($configuration->getName(), $eleve);

		return true ;
	}

}