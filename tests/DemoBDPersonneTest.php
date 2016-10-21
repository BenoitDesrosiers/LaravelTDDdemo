<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Personne;


class DemoBDPersonneTest extends TestCase
{
	use DatabaseTransactions;
	
    /** @test */
    public function sauvegarde_simple_du_modele()
    {
        $personne = new Personne;
        $personne->nom = "Nom Valide";
        $personne->dateNaissance = '2000-12-25';
        $this->assertTrue($personne->validate(),'la personne de base ne valide pas');
        $this->assertTrue($personne->save());
        $this->seeInDatabase('personnes', [
        		'id'=>$personne->id,
        		'nom'=>$personne->nom,
        		'dateNaissance'=>$personne->dateNaissance,
        		'telephone'=>$personne->telephone
        ]);
        
    }
}
