<?php

return array(

	/**
	 * You can get a steam API key from https://steamcommunity.com/dev/apikey
	 * Once you get your key, add it here.
	*/
	'steamApiKey' => env('STEAM_API_KEY'),

    /**
     * Steam Web API url
     */
    'steamApiUrl' => env('STEAM_API_URL', 'https://api.steampowered.com')

);
