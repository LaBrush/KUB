<?php

namespace Kub\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class KubUserBundle extends Bundle
{

	public function getParent()
	{
		return 'FOSUserBundle' ;
	}

}
