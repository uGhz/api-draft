<?php
namespace biusante\api;

class BiographiesProvider {
	
	const SQL_SELECT_BIOGRAPHIE_BY_ID = <<<'EOT'
	SELECT
		cle as refbiogr,
		nom_complet as nomComplet,
		Commentaire as commentaire,
		deces_annee as dateDeces,
		naissance_annee as dateNaissance,
		deces_lieu as lieuDeces,
		naissance_lieu as lieuNaissance,
		ref_biblio as referencesBibliographiques,
		lien_biogr_refphot as referenceBanqueImages
	FROM biographies
	WHERE cle = :id
EOT;
	
	private $container;
	
	public function __construct(\Slim\Container $container) {
		$this->container = $container;
	}
	
	public function selectBiographie($id) {
		$pdo = $this->container->db;
		$stmt = $pdo->prepare(self::SQL_SELECT_BIOGRAPHIE_BY_ID);
		$stmt->execute(array('id' => $id));
		
		// Récupération des résultats sous forme d'objet du domaine.
		$stmt->setFetchMode( \PDO::FETCH_CLASS, "\biusante\api\Biographie");
		$result = $stmt->fetch();

		// print_r($result);
		return $result;
	}
}