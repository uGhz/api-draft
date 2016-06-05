<?php
namespace biusante\api;

class MainApiService {
	
	private $app;
	
	public function __construct(\Slim\App $app) {
		$this->app = $app;
	}
	
	public function getJsonBiographie($id) {
		$provider = new BiographiesProvider($this->app);
		$rawResults = $provider->selectBiographie($id);
		
		// Mettre les résultats au format JSON.
		
	}
}