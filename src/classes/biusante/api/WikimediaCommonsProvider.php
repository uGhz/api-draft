<?php
namespace biusante\api;

class WikimediaCommonsProvider {
	
	const WIKIMEDIA_COMMONS_BASE_URL = 'https://commons.wikimedia.org/w/api.php';
	const QUERY_IMAGES_BY_CATEGORY = '?format=json&action=query&list=categorymembers&cmtype=file&cmtitle=Category:';

	private $container;
	
	public function __construct(\Slim\Container $container) {
		$this->container = $container;
	}
	
	public function getImagesByCategory($category) {
		$url = self::WIKIMEDIA_COMMONS_BASE_URL;
		$query = self::QUERY_IMAGES_BY_CATEGORY . urlencode($category);
		$url = $url . $query;
		$this->container->logger->info("Before Wikimedia Commons request");
		
		$result = file_get_contents($url);
		$this->container->logger->info("After Wikimedia Commons request");
		$this->container->logger->info(var_export($result, TRUE));

		// print_r($result);
		return $result;
	}
}