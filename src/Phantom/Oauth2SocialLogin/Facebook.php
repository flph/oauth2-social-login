<?php namespace Phantom\Oauth2SocialLogin;

use Illuminate\Support\Facades\Facade;

class Facebook extends Facade {
	/**
	 * Get the binding in the IoC container
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'facebook';
	}
}