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
		$id = $args['id'];
		// Trace route
		$this->logger->info("Slim-Skeleton '/biographies/{id}' route. Biographie demandée : " . $id);
	
		try {
			$service = new \biusante\api\MainApiService($this);
			$jsonResults = $service->getJsonBiographie($id);
			$this->logger->info("Service Response : " . var_export($jsonResults, TRUE));
			if (!empty($jsonResults) && $jsonResults != 'false') {
				// if found, return JSON response
				$response = $response->withHeader('Content-type', 'application/json');
				$response->getBody()->write($jsonResults);
			} else {
				// return 404 server error
				$response = $response->withStatus(404);
			}
		} catch (Exception $e) {
			$response = $response->withStatus(400);
			$response = $response->withHeader('X-Status-Reason', $e->getMessage());
		}
		
		return $response;
	});
