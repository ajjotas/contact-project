<?php

namespace Tests\Feature\Repository;


use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;
use App\Repository\Eloquent\ContatoRepository;

class ContatoRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @dataProvider camposValidosProvider
     */
    public function create_camposValidos_contatoCriado($campos)
    {
        $repository = app('App\Repository\Eloquent\ContatoRepository');

        $repository->create($campos);
        
        $this->assertDatabaseHas('contato', [
            'nome' => 'Nome Teste', 
            'email' => 'teste@gmail.com', 
            'telefone' => '3133333333',
            'mensagem' => 'Mensagem teste', 
            'path' => '\test', 
            'ip' => '1.1.1.1'
        ]);    
    }    

    public function camposValidosProvider()
    {                             
        return [
            'campos_validos' => [
                ['nome' => 'Nome Teste', 'email' => 'teste@gmail.com', 'telefone' => '3133333333', 'mensagem' => 'Mensagem teste', 'path' => '\test', 'ip' => '1.1.1.1'],   
            ],                                                
        ];
    }        


}
