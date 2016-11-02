<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DemoCtrlPersonneUnitTest extends TestCase
{
     /**
     * @test
     */
    public function le_ctrl_envoie_les_personnes_a_la_view()
    {
    	
    	$response = $this->call('get', '/personnes'); 
    	$this->assertViewHas('personnes');
    	$personnes = $response->original->getData()['personnes'];
    	$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $personnes);
    	 
    }
}
