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
		$this->app->bindShared('facebook', function ($app) {
			return new Oauth2FacebookLogin($app['config']);
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
