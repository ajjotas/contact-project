<?php

namespace Tests\Feature\Controller;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Mockery\MockInterface;

use App\Repository\Eloquent\ContatoRepository;
use App\Mail\NovoContato;
use App\Contato;

use Tests\TestCase;


class ContatoControllerTest extends TestCase
{
    /**
     * @test
     */
    public function add_camposValidos_gravaArquivoPersisteContatoEMandaEmail()
    {
        Storage::fake('local');
        $countFiles = count(Storage::disk('local')->allFiles());        
        Mail::fake();
        $this->mock(ContatoRepository::class, function (MockInterface $mock) {
            $mock->allows([
                'create' => $this->retornoCreate()                     
            ]);
        });        

        $parametros =  $this->parametrosValidos();
        $response = $this->post('/api/contato/add', $parametros);

        $this->assertTrue(count(Storage::disk('local')->allFiles()) == $countFiles + 1);
        Mail::assertSent(NovoContato::class);
        $response->assertStatus(200);
    }

    /**
     * @test
     */    
    public function add_camposInvalidos_retornaResponseComStatusErro()
    {
        Storage::fake('local');
        $countFiles = count(Storage::disk('local')->allFiles()); 
        Mail::fake();
        $this->mock(ContatoRepository::class, function (MockInterface $mock) {
            $mock->allows([
                'create' => $this->retornoCreate()                     
            ]);
        });        

        $parametros =  $this->parametrosInvalidos();
        $response = $this->post('/api/contato/add', $parametros);

        $this->assertTrue(count(Storage::disk('local')->allFiles()) == $countFiles);
        Mail::assertNotSent(NovoContato::class);
        $response->assertStatus(302);
    }    

    private function parametrosValidos() {
        return [
            'nome' => 'Nome Teste',
            'email' => 'teste@gmail.com',
            'telefone' => '3133333333',
            'mensagem' => 'Teste',
            'arquivo' => UploadedFile::fake()->create('file.pdf', 400)
        ];
    }

    private function parametrosInvalidos() {
        return [
            'nome' => null,
            'email' => 'teste@gmail.com',
            'telefone' => '3133333333',
            'mensagem' => 'Teste',
            'arquivo' => null
        ];
    }    

    private function retornoCreate() {
        $contato = new Contato();

        $contato->fill([
            'id' => '1',
            'nome' => 'Nome Teste',
            'email' => 'teste@gmail.com',
            'telefone' => '3133333333',
            'mensagem' => 'Teste',            
            'path' => '/path/file.pdf'
        ]);

        return $contato;
    }    

}
