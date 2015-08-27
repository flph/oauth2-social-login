<?php namespace Phantom\Oauth2SocialLogin;

use Illuminate\Support\ServiceProvider;

class Oauth2SocialLoginServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bindShared('facebook', function () {
			return $this->app->make('Phantom\Oauth2SocialLogin\Oauth2FacebookLogin');
		});
	}

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('phantom/oauth2-social-login');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['facebook'];
	}

}
