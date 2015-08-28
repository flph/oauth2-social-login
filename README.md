# Oauth2 Social Login Package for Laravel 4

This package is very easy to integrate with any project that needs to login with and oauth2 client.

It implements the oauth flow:

* Log in with a social provider
* Connect an existing user record with a social provider
* Perform requests against the social provider API with each user's unique access token

## Supported Services

At this time is only implemented facebook provider.

## Installation Via Composer

Add this to your composer.json file, in the require object:

```javascript
"phantom/oauth2-social-login": "^0.0.1"
```

After that, run composer install to install the package.

Add the service provider to `app/config/app.php`, within the `providers` array.

```php
'providers' => array(
	// ...
	'Phantom\Oauth2SocialLogin\Oauth2SocialLoginServiceProvider',
)
```

## Configuration

Publish the default config file to your application so you can make modifications.

```console
$ php artisan config:publish phantom/oauth2-social-login
```

Add your service provider credentials to the published config file: `app/config/packages/phantom/oauth2-social-login/facebook.php`

## Basic Usage

You may put a link on a view that redirect the user to the oAuth log in page for a provider.
```php
<a href="{{ {{Facebook::getLoginUrl()}} }}">
	Connect Your Facebook Account
</a>
```

On the controller that parse the redirect uri you defined on config request the token to the provider.

```php
$code = Input::get('code');
$token = Facebook::getToken($code);
```

Once you have the token, you may do any call to the provider api you want.
For instance there is a simple function to request the user own profile data.

```php
$user = Facebook::getUserInfo($token);
```

#### Error Handling

You may use try catch control to catch if something goes wrong

```php
	try{}catch(Exception $exp){
		switch($exp->getCode()){
			case 401: //The provider did not provide you and access token
				break;
			case 415: //The response with user info have bad formatted data
				break;
			default: //There was a problem connecting to provider
		}
	}
```		

#### Requirements

This implementation assumes that you want to allow your users to log in or sign up seamlessly with their existing social provider account and associate that social provider account with an existing user record.

#### Social Login Flow

Simply create a link to the built-in controller to initiate a log in flow. The user will be redirected to the provider login page before they return to your website.

If an existing user is already linked to the provider account, they will be logged in as that user.

If an existing user is not found for the provider account, a new user record will be created and then a link to the provider account will be made before they are logged in as that user.

You can also associate a social provider account to an existing user if they are already logged in.
