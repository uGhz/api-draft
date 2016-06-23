<?php
namespace biusante\api;

class ViafProvider {
	
	private $container;
	
	public function __construct(\Slim\Container $container) {
		$this->container = $container;
	}
	
	public function getLinksByViafId($viafId) {

		$url = $this->buildUrl($viafId);
		$this->container->logger->info("Before VIAF Links request : " . $url);
		
		$result = file_get_contents($url);
		$this->container->logger->info("After VIAF Links request");
		$this->container->logger->info(var_export($result, TRUE));

		// print_r($result);
		return $result;
	}
	
	private function buildUrl($viafId) {
		$url = "http://viaf.org/viaf/" . $viafId . "/justlinks.json";

		return $url;
	}
}