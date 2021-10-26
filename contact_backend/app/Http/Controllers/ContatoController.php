<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests\AddContatoRequest;
use App\Repository\ContatoRepositoryInterface;
use App\Mail\NovoContato;


class ContatoController extends Controller
{
    private $contatoRepository;
  
    public function __construct(ContatoRepositoryInterface $contatoRepository)
    {
        $this->contatoRepository = $contatoRepository;
    } 

    public function add(AddContatoRequest $request)
    {
        $arquivo = $request->file('arquivo');

        if($arquivo) {
            $nomeArquivo = time().'_'.$arquivo->getClientOriginalName();
            $caminhoArquivo = Storage::putFileAs('/public/uploads', $arquivo, $nomeArquivo);

            $contato = $this->contatoRepository->create([
                'nome' => $request->nome,
                'email' => $request->email,
                'telefone' => $request->telefone,
                'mensagem' => $request->mensagem,
                'path' => '/'.$caminhoArquivo,
                'ip' => $request->ip()
            ]);

            Mail::to(config('mail.to'))->send(new NovoContato($contato));

            return response()->json(['success'=>'Contato gravado com sucesso.']);
        }    
    }
}
