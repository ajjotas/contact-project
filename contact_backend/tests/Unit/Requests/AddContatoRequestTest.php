<?php

namespace Tests\Unit\Requests;

use Illuminate\Http\UploadedFile;

use Tests\TestCase;
use App\Http\Requests\AddContatoRequest;

class AddContatoRequestTest extends TestCase
{
    /**
     * @test
     * @dataProvider camposInvalidosProvider
     */
    public function rules_camposInvalidos_naoPassaNaValidacao($campos, $erroEsperado)
    {
        $rules = $this->getRules();        
        $validatorFactory = $this->getValidatorFactory();

        $validator = $validatorFactory->make($campos, $rules);
        $validacaoPassou = $validator->passes();
        $errosValidacao = $validator->failed();

        $this->assertFalse($validacaoPassou);
        $this->assertCount(1, $errosValidacao);
        $this->assertArrayHasKey($erroEsperado['input'], $errosValidacao);
        $this->assertCount(1, $errosValidacao[$erroEsperado['input']]);
        $this->assertArrayHasKey($erroEsperado['rule'], $errosValidacao[$erroEsperado['input']]);        
    }

    /**
     * @test
     * @dataProvider camposValidosProvider
     */
    public function rules_camposValidos_passaNaValidacao($campos)
    {
        $rules = $this->getRules();        
        $validatorFactory = $this->getValidatorFactory();

        $validator = $validatorFactory->make($campos, $rules);
        $validacaoPassou = $validator->passes();

        $this->assertTrue($validacaoPassou);        
    }    

    protected function getRules() {
        $request = new AddContatoRequest();
        return $request->rules();
    }

    protected function getValidatorFactory() {
        return $this->app['validator'];
    }

    public function camposInvalidosProvider()
    {
        $htmlFile =  UploadedFile::fake()->create('document.html', '400');
        $bigFile =  UploadedFile::fake()->create('document.pdf', 5000);        
        $pdfFile =  UploadedFile::fake()->create('document.pdf', 400);  

        return [
            'sem_nome' => [
                ['nome' => null, 'email' => 'teste@gmail.com', 'telefone' => '3133333333', 'mensagem' => 'Mensagem teste', 'arquivo' => $pdfFile],
                ['input' => 'nome', 'rule' => 'Required']                
            ],
            'nome_mais_100_caracteres' => [
                ['nome' => 'abcdefghijklmno pqppwoeiruus ajqjsklka nbebnwjwjqkis akdlskdoq swmlcksla saçlslkeojkffg wqe qwe qe qeqe', 
                    'email' => 'teste@gmail.com', 'telefone' => '3133333333', 'mensagem' => 'Mensagem teste', 'arquivo' => $pdfFile],
                ['input' => 'nome', 'rule' => 'Max']                
            ],    
            'sem_email' => [
                ['nome' => 'Nome Teste', 'email' => null, 'telefone' => '3133333333', 'mensagem' => 'Mensagem teste', 'arquivo' => $pdfFile],
                ['input' => 'email', 'rule' => 'Required']                
            ],
            'email_invalido' => [
                ['nome' => 'Nome Teste', 'email' => 'teste', 'telefone' => '3133333333', 'mensagem' => 'Mensagem teste', 'arquivo' => $pdfFile],
                ['input' => 'email', 'rule' => 'Email']                
            ],  
            'email_mais_100_caracteres' => [
                ['nome' => 'Nome Teste', 'email' => 'abcdefghijklmnopqppwoeiruusajqjsklka@nbebnwjwjqkisakdlskdoqswmlckslasaçlslkeojkffgwqeqweqeqeqesdawqe.com', 
                    'telefone' => '3133333333', 'mensagem' => 'Mensagem teste', 'arquivo' => $pdfFile],
                ['input' => 'email', 'rule' => 'Max']                
            ],      
            'sem_telefone' => [
                ['nome' => 'Nome Teste', 'email' => 'teste@gmail.com', 'telefone' => null, 'mensagem' => 'Mensagem teste', 'arquivo' => $pdfFile],
                ['input' => 'telefone', 'rule' => 'Required']                
            ],
            'telefone_com_letras' => [
                ['nome' => 'Nome Teste', 'email' => 'teste@gmail.com', 'telefone' => '31333ab333', 'mensagem' => 'Mensagem teste', 'arquivo' => $pdfFile],
                ['input' => 'telefone', 'rule' => 'DigitsBetween']                
            ],  
            'telefone_com_menos_10_digitos' => [
                ['nome' => 'Nome Teste', 'email' => 'teste@gmail.com', 'telefone' => '313333389', 'mensagem' => 'Mensagem teste', 'arquivo' => $pdfFile],
                ['input' => 'telefone', 'rule' => 'DigitsBetween']                
            ],   
            'telefone_com_mais_11_digitos' => [
                ['nome' => 'Nome Teste', 'email' => 'teste@gmail.com', 'telefone' => '313333389154', 'mensagem' => 'Mensagem teste', 'arquivo' => $pdfFile],
                ['input' => 'telefone', 'rule' => 'DigitsBetween']                
            ],   
            'sem_mensagem' => [
                ['nome' => 'Nome Teste', 'email' => 'teste@gmail.com', 'telefone' => '3133333333', 'mensagem' => null, 'arquivo' => $pdfFile],
                ['input' => 'mensagem', 'rule' => 'Required']                
            ],
            'mensagem_mais_400_caracteres' => [
                ['nome' => 'Nome teste', 'email' => 'teste@gmail.com', 'telefone' => '3133333333', 
                    'mensagem' => 'abcdefghijwqeqw qwe qweqw eq qeq qw klmn opqppwoeiruusajqjsklkahg nbebnwjwjqkisakdlskdoqs wmlckslasaflslkeojkf fgwqeqweqeqeqesdawqe com abcdefghijklmn opqppwoeiruusajqjsklkahg nbebnwjwjqkisakdlskdoqs wmlckslasaalslkeojkf fgwqeqweqeqeqesdawqe com  abcdefghijklmn opqppwoeiruusajqjsklkahg nbebnwjwjqkisakdlskdoqs wmlckslasaalslkeojkf fgwqeqweqeqeqesdawqe com abcdefghijklmn opqppwoeiruusajqjsklkahg nbebnwjwjqkisakdldfsdf sdrtrq',                     
                    'arquivo' => $pdfFile],
                ['input' => 'mensagem', 'rule' => 'Max']                
            ],                 
            'sem_arquivo' => [
                ['nome' => 'Nome Teste', 'email' => 'teste@gmail.com', 'telefone' => '3133333333', 'mensagem' => 'Mensagem teste', 'arquivo' => null],
                ['input' => 'arquivo', 'rule' => 'Required']                
            ],
            'arquivo_formato_invalido' => [
                ['nome' => 'Nome Teste', 'email' => 'teste@gmail.com', 'telefone' => '3133333333', 'mensagem' => 'Mensagem teste', 'arquivo' => $htmlFile],
                ['input' => 'arquivo', 'rule' => 'Mimes']                
            ],  
            'arquivo_tamanho_invalido' => [
                ['nome' => 'Nome Teste', 'email' => 'teste@gmail.com', 'telefone' => '3133333333', 'mensagem' => 'Mensagem teste', 'arquivo' => $bigFile],
                ['input' => 'arquivo', 'rule' => 'Max']                
            ],                                                  
        ];
    }    

    public function camposValidosProvider()
    {
        $pdfFile =  UploadedFile::fake()->create('document.pdf', 400);    
        $docFile =  UploadedFile::fake()->create('document.doc', 400); 
        $docxFile =  UploadedFile::fake()->create('document.docx', 400); 
        $odtFile =  UploadedFile::fake()->create('document.odt', 400); 
        $txtFile =  UploadedFile::fake()->create('document.txt', 400);                         

        return [
            'campos_validos_com_arquivo_pdf' => [
                ['nome' => 'Nome Teste', 'email' => 'teste@gmail.com', 'telefone' => '3133333333', 'mensagem' => 'Mensagem teste', 'arquivo' => $pdfFile],   
            ],
            'campos_validos_com_arquivo_doc' => [
                ['nome' => 'Nome Teste', 'email' => 'teste@gmail.com', 'telefone' => '3133333333', 'mensagem' => 'Mensagem teste', 'arquivo' => $docFile],   
            ],
            'campos_validos_com_arquivo_docx' => [
                ['nome' => 'Nome Teste', 'email' => 'teste@gmail.com', 'telefone' => '3133333333', 'mensagem' => 'Mensagem teste', 'arquivo' => $docxFile],   
            ],
            'campos_validos_com_arquivo_odt' => [
                ['nome' => 'Nome Teste', 'email' => 'teste@gmail.com', 'telefone' => '3133333333', 'mensagem' => 'Mensagem teste', 'arquivo' => $odtFile],   
            ],
            'campos_validos_com_arquivo_txt' => [
                ['nome' => 'Nome Teste', 'email' => 'teste@gmail.com', 'telefone' => '3133333333', 'mensagem' => 'Mensagem teste', 'arquivo' => $txtFile],   
            ],                                                
        ];
    }        


}
