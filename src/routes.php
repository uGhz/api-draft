<?php
use biusante\api\MainApiService as MainApiService;
// Routes

$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});


	$app->get('/biographies/{id}', function ($request, $response, $args) {
		// Sample log message
		$this->logger->info("Slim-Skeleton '/biographies/{id}' route. Biographie demandée : " . $args['id']);
	
		$service = new \biusante\api\MainApiService($this);
		
		// Render index view
		return $this->renderer->render($response, 'index.phtml', $args);
	});
