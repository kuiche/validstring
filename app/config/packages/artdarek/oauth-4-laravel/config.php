<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
            'client_id'     => '',
            'client_secret' => '',
            'scope'         => array(),
        ),

		/**
		 * Twitter
		 */
        'Twitter' => array(
            'client_id'     => '83915254',
            'client_secret' => 'r8xzqR2IcDjKOwCwgm9LlS7Mnr3FImVNI5WkeWB4kb3BIcbQt8',
            'scope'         => array(),
        ),		

	)

);