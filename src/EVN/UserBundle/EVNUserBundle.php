<?php

namespace EVN\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EVNUserBundle extends Bundle
{

	public function getParent()
	{
		return 'FOSUserBundle' ;
	}

}
