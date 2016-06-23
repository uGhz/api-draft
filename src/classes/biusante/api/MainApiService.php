<?php

namespace biusante\api;

class MainApiService {
	
	private $container;
	
	public function __construct(\Slim\Container $container) {
		$this->container = $container;
	}
	
	public function getJsonBiographie($id) {
		$provider = new BiographiesProvider($this->container);
		$biographie = $provider->selectBiographie($id);
		
		// Mettre les résultats au format JSON.
		return json_encode($biographie);
	}
	
	public function getViafJsonLinks($id) {
		$provider = new ViafProvider($this->container);
		$links = $provider->getLinksByViafId($id);
	
		return $links;
	}
	
	public function getWikidataJsonBiographie($id) {
		$provider = new WikidataProvider($this->container);
		$biographie = $provider->getBiographieByWikidataId($id);
	
		return $biographie;
	}
	
	public function getWikimediaCommonsJsonCategoryImages($category) {
		$provider = new WikimediaCommonsProvider($this->container);
		$images = $provider->getImagesByCategory($category);
	
		return $images;
	}
	
	private function jsonEncode($object) {
		return json_encode($object);
	}
	
	/**
	TODO. Méthode d'encodage XML à valider.
	private function xmlEncode($object) {
		return $this->xmlRecursiveEncoding($object);
	}
	
	private function xmlRecursiveEncoding($mixed, $domElement = NULL, $DOMDocument = NULL) {
		if (is_null($DOMDocument)) {
			$DOMDocument = new \DOMDocument;
			$DOMDocument->formatOutput = true;
	
			$rootNode = $DOMDocument->createElement('entries');
			$DOMDocument->appendChild($rootNode);
	
			$this->xmlRecursiveEncoding($mixed, $rootNode, $DOMDocument);
	
			echo @$DOMDocument->saveXML();
		} else {
			if (is_array($mixed)) {
				foreach ($mixed as $index=>$mixedElement) {
					if (is_int($index)) {
						$nodeName = 'entry';
					} else {
						$nodeName = $index;
					}
					$node = $DOMDocument->createElement($nodeName);
					$domElement->appendChild($node);
					$this->xmlRecursiveEncoding($mixedElement, $node, $DOMDocument);
				}
			} else {
				// TODO: test if CDATA if needed
				$new_node = $DOMDocument->createTextNode($mixed);
	
				$domElement->appendChild($new_node);
			}
		}
	}
	*/


}