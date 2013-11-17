<?php

namespace Kub\MessageBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class KubMessageBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSMessageBundle';
	}
}
