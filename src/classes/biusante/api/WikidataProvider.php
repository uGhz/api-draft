<?php
namespace biusante\api;

class wikidataProvider {
	
	const WIKIDATA_BASE_URL = 'https://query.wikidata.org/sparql?format=json&query=';
	const SPARQL_SELECT_BIOGRAPHIE_BY_ID = <<<'EOT'
PREFIX wdt: <http://www.wikidata.org/prop/direct/>
SELECT
	?item
	?itemLabel
	?itemDescription
	?illustration
	?lieuNaissanceLabel
	?lieuDecesLabel
	?dateNaissance
	?dateDeces
	?nationaliteLabel
	(GROUP_CONCAT(DISTINCT(?occupationLabel); separator="|") as ?occupations)
WHERE {
  ?item wdt:P214 ":id" .
  ?item wdt:P18 ?illustration .
  ?item wdt:P19 ?lieuNaissance .
  ?item wdt:P20 ?lieuDeces .
  ?item wdt:P569 ?dateNaissance .
  ?item wdt:P570 ?dateDeces .
  ?item wdt:P27 ?nationalite .
  ?item wdt:P106 ?occupation .
  ?occupation rdfs:label ?occupationLabel .
  FILTER (LANG(?occupationLabel) = 'fr') .
  SERVICE wikibase:label {
    bd:serviceParam wikibase:language "fr,en"
  }
}
GROUP BY ?item ?itemLabel ?itemDescription ?illustration ?lieuNaissanceLabel ?lieuDecesLabel ?dateNaissance ?dateDeces ?nationaliteLabel
LIMIT 1
EOT;
	
	private $container;
	
	public function __construct(\Slim\Container $container) {
		$this->container = $container;
	}
	
	public function getBiographie($id) {
		$url = self::WIKIDATA_BASE_URL;
		$request = str_replace(":id", $id, self::SPARQL_SELECT_BIOGRAPHIE_BY_ID);
		$url = $url . urlencode($request);
		$this->container->logger->info("Before Wikidata request");
		
		$result = file_get_contents($url);
		$this->container->logger->info("After Wikidata request");
		$this->container->logger->info(var_export($result, TRUE));

		// print_r($result);
		return $result;
	}
}