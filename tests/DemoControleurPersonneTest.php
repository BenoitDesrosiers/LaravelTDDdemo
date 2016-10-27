<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Personne;

class DemoControleurPersonneTest extends TestCase
{
	use DatabaseTransactions;
	
	
    /**
     * @test
     */
    public function la_route_index_existe()
    {
        $this->call('get', '/personnes');
    }
    
    /**
     * @test
     */
    public function le_ctrl_envoie_les_personnes_a_la_view()
    {
    	
    	$response = $this->call('get', '/personnes'); 
    	$this->assertViewHas('personnes');
    	$response = $this->call('get','/personnes');
    	$personnes = $response->original->getData()['personnes'];
    	$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $personnes);
    	 
    }
    
    /**
     * @test
     */
    public function le_ctrl_envoie_la_liste_des_personnes_a_la_view()
    {
 
    	$personne = new Personne;
    	$personne->nom = "Nom Valide";
    	$personne->dateNaissance = '2000-12-25';
    	$this->assertTrue($personne->save());
    	
    	$response = $this->call('get','/personnes');
    	$personnes = $response->original->getData()['personnes'];
    	$this->assertTrue($personnes->contains('nom', 'Nom Valide'), 'personnes ne contient pas les personnes sauvegardées');
    	
    }
    
}
