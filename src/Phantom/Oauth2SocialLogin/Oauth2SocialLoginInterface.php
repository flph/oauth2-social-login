<?php namespace Phantom\Oauth2SocialLogin;

interface Oauth2SocialLoginInterface {

	/**
	 * Get the redirect url the login url
	 *
	 * @return string
	 */
	public function getLoginUrl();

	/**
	 * Get Authorization token from oauth2 provider
	 *
	 * @param string $code The access code from oauth provider
	 * @param string $expire date when the token expire
	 *
	 * @return string Access token
	 * @throws \Exception
	 */
	public function getToken($code, &$expire = '');

	/**
	 * Get own profile user info
	 *
	 * @param string $token The authorization token
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function getUserInfo($token);
}