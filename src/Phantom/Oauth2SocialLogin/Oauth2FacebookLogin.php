<?php namespace Phantom\Oauth2SocialLogin;

use Config;
use Exception;
use Redirect;

class Oauth2FacebookLogin implements Oauth2SocialLoginInterface {

	#Private config section
	private $authorizationBaseUrl;
	private $tokenUrl;
	private $clientId;
	private $clientSecret;
	private $redirectUri;
	private $profileUrl;
	private $scope;

	/**
	 * The constructor
	 */
	public function __construct()
	{
		$this->authorizationBaseUrl = Config::get('oauth2-social-login::facebook.authorization_base_url');
		$this->tokenUrl             = Config::get('oauth2-social-login::facebook.token_url');
		$this->clientId             = Config::get('oauth2-social-login::facebook.client_id');
		$this->clientSecret         = Config::get('oauth2-social-login::facebook.client_secret');
		$this->redirectUri          = Config::get('oauth2-social-login::facebook.redirect_uri');
		$this->profileUrl           = Config::get('oauth2-social-login::facebook.profile_url');
		$this->scope                = implode(',', Config::get('oauth2-social-login::facebook.scopes'));
	}

	/**
	 * Get the redirect url to the facebook login url
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function getLoginUrl()
	{
		return "$this->authorizationBaseUrl?client_id=$this->clientId&redirect_uri=$this->redirectUri&scope=$this->scope";
	}

	/**
	 * Get Authorization token from facebook
	 *
	 * @param string $code The facebook post code
	 *
	 * @return string Access token
	 * @throws \Exception
	 */
	public function getToken($code)
	{
		#Build token url
		$token_url = "$this->tokenUrl?client_id=$this->clientId&redirect_uri=$this->redirectUri&client_secret=$this->clientSecret&code=$code";

		#Connect to facebook
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $token_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		$error    = curl_errno($ch);
		curl_close($ch);

		#Extract Token
		if ($response) {
			$params = null;
			parse_str($response, $params);

			if (!empty($params['access_token'])) {
				return $params['access_token'];
			} else {
				throw new Exception('No access token', '401');
			}

		}

		#If no response or token
		if ($error) {
			$error_message = curl_strerror($error);
			throw new Exception($error_message, $error);
		}
	}

	/**
	 * Get own profile user info
	 *
	 * @param string $token The authorization token
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function getUserInfo($token)
	{
		#Build profile url
		$graph_url = "$this->profileUrl?access_token=$token";

		#Fetch Profile Data
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $graph_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		$error    = curl_errno($ch);
		curl_close($ch);

		#If no response
		if ($error) {
			$error_message = curl_strerror($error);
			throw new Exception($error_message, $error);
		}

		#Decode response
		$decoded = json_decode($response, true);

		#If invalid response
		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new Exception('Bad formatted response', 415);
		}

		return $decoded;
	}
}