<?php
namespace biusante\api;

class WikimediaCommonsProvider {
	
	const WIKIMEDIA_COMMONS_BASE_URL = 'https://commons.wikimedia.org/w/api.php';

	const MAX_WIDTH = 300;
	const MAX_HEIGHT = null;
	const MAX_RESULTS = 20;
	
	private $container;
	
	public function __construct(\Slim\Container $container) {
		$this->container = $container;
	}
	
	public function getImagesByCategory($category) {
		$url = self::WIKIMEDIA_COMMONS_BASE_URL;
		$url = $url . $this->buildQueryString($category);
		$this->container->logger->info("Before Wikimedia Commons request : " . $url);
		
		$result = file_get_contents($url);
		$this->container->logger->info("After Wikimedia Commons request");
		$this->container->logger->info(var_export($result, TRUE));

		// print_r($result);
		return $result;
	}
	
	private function buildQueryString($category) {
		$queryString = '?format=json&action=query&generator=categorymembers';
		$queryString .= '&gcmtype=file&prop=info|imageinfo';
		$queryString .= '&gcmlimit=' . self::MAX_RESULTS;
		$queryString .= '&iiprop=url';
		$queryString .= '&iiurlwidth=' . self::MAX_WIDTH;
		$queryString .= '&iiurlheight=' . self::MAX_HEIGHT;
		$queryString .= '&gcmtitle=Category:' . urlencode($category);
		return $queryString;
	}
}