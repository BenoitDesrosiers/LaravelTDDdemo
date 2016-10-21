<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Personne;

class DemoValidationPersonneTest extends TestCase
{
	protected $person; 
	
	public function setUp()
	{
		parent::setUp();
		
		$this->personne = new Personne;
		$this->personne->nom = 'un bon nom';
		$this->personne->dateNaissance = '2000-12-25';
		$this->personne->telephone = '123-123-1234';
		
	}
//Validation de base
	
	/* rqt-1: avoir des personnes */
	/** @test */
	public function une_personne_sans_attributs_n_est_pas_valide()
	{
		$personneVide = new Personne;
		$this->assertFalse($personneVide->validate(), "la validation passe sans aucun attributs");
	}
	
	/* rqt-1: avoir des personnes */
	/** @test */
	public function la_personne_par_defaut_est_valide()
	{
		$this->assertTrue($this->personne->validate(), "la personne par défaut du test ne valide plus");
	}
	
	/* rqt-1: avoir des personnes */
	/** @test 
	 * @dataProvider nullProvider 
	 */
	public function tous_les_attributs_obligatoires_sont_present($nom,$dateNaissance)
	{
		
		$this->personne->nom = $nom;
		$this->personne->dateNaissance = $dateNaissance;
		$this->assertFalse($this->personne->validate(), "la validation passe avec un attribut obligatoire manquant");
	}
	
	public function nullProvider()
	{
		return [
				'nomNull' => [null, '2016-01-01'],
				'dateNaissanceNull' => ['Un Nom', null]
		];
	}
	
// Validation de la date de naissance	
	/* rqt-1: avoir des personnes, format de la date */
	
	/** @test
	 * @dataProvider mauvaisFormatNaissanceProvider
	 */
	public function refuse_les_dates_mal_formatées($dateNaissance)
	{		
		$this->personne->dateNaissance = $dateNaissance;
		$this->assertFalse($this->personne->validate(), "la validation passe avec une date mal formatée");
	}
	
	public function mauvaisFormatNaissanceProvider()
	{
		return [
				'DateNaissanceNonNumerique' => ['Date'],
				'DateNaissanceAA_MM_JJ' => ['00-12-25'],
				'DateNaissanceJJ_MM_AAAA' => ['25-12-2000'],
				'DateNaissanceAAAA_JJ_MM' => ['2000-25-12'],
				'DateNaissance9999_99_99' => ['9999-99-99'],
		];
	}
	
	/* rqt-1: avoir des personnes, format de la date*/
	
	/** @test
	 * @dataProvider bonFormatNaissanceProvider
	 */
	public function accepte_les_dates_bien_formatées($dateNaissance)
	{
		$this->personne->dateNaissance = $dateNaissance;
		$this->assertTrue($this->personne->validate(), "la validation ne passe pas avec une date bien formatée");
	}
	public function bonFormatNaissanceProvider()
	{
		return [
				'DateNaissanceAAAA_MM_JJ' => ['2000-12-25'],
				'DateNaissanceAAAA_J_MM' => ['2000-1-12'],
				'DateNaissanceAAAA_JJ_M' => ['2000-01-9']
	    		];
	}
		
// Validation du téléphone	
	/* rqt-1: avoir des personnes, format du téléphone */
	/** @test
	 * @dataProvider mauvaisFormatTelephoneProvider
	 */
	public function refuse_les_telephone_mal_formatés($telephone)
	{
		$this->personne->telephone = $telephone;
		$this->assertFalse($this->personne->validate(), "la validation passe avec un téléphone mal formaté");
	}
	
	public function mauvaisFormatTelephoneProvider()
	{
		return [
				'TelephoneNonNumerique' => ['telephone'],
				'TelephoneAvec1' => ['1-999-999-9999'],
				'TelephoneSansIndicatif' => ['999-9999'],
				'TelephoneMauvaisFormat1' => ['99-999-9999'],
				'TelephoneMauvaisFormat2' => ['999-99-9999'],
				'TelephoneMauvaisFormat3' => ['999-999-999'],
		];
	}
	
	/* rqt-1: avoir des personnes, format du téléphone */
	/** @test
	 * @dataProvider bonFormatTelephoneProvider
	 */
	public function accepte_les_telephones_bien_formatés($telephone)
	{
		$this->personne->telephone = $telephone;
		$this->assertTrue($this->personne->validate(), "la validation ne passe pas avec un téléphone bien formaté");
	}
	public function bonFormatTelephoneProvider()
	{
		return [
				'TelephoneBonFormat' => ['123-123-1234'],
		];
	}
	
	
}
