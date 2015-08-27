<?php

return [
		#Config taken from application registration
		'client_id' => '',
		'client_secret' => '',
		'scopes' => ['email'],
		'redirect_uri' => '', #The url should be on the same domain as website

		#OAuth endpoints given in the Facebook API documentation
		'authorization_base_url' => 'https://www.facebook.com/dialog/oauth',
		'token_url' => 'https://graph.facebook.com/oauth/access_token',
		'profile_url' => 'https://graph.facebook.com/me'
];