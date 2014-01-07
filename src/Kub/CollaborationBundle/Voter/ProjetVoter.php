<?php

namespace Kub\CollaborationBundle\Voter;

use Kub\CollaborationBundle\Entity\Projet;
use Kub\CollaborationBundle\Entity\Permission;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ProjetVoter implements VoterInterface
{
	private $em;
	private $classConstant ;

	public function __construct($em)
	{
		$this->em = $em ;
		$this->classConstant = (new \ReflectionClass ( 'Kub\CollaborationBundle\Entity\Permission' ))->getConstants();
	}

	public function supportsAttribute($attribute)
	{
		return in_array($attribute, array_keys($this->classConstant));
	}

	public function supportsClass($class)
	{
		return $class instanceof Projet ;
	}

	function vote(TokenInterface $token, $object, array $attributes)
	{
		$user = $token->getUser();

		foreach ($attributes as $attribute) {
			if ($this->supportsAttribute($attribute) && $this->supportsClass($object)) {

				foreach ($object->getPermissions() as $permission) {
					if(
						$permission->getUser()->getId() == $user->getId() && 
						$permission->getRole() >= $this->classConstant[$attribute]
					)
					{
						return VoterInterface::ACCESS_GRANTED;
					}
				}
				
			}
		}
		
		return VoterInterface::ACCESS_DENIED;
	}
}