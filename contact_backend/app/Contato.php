<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $table = 'contato';
    protected $primaryKey = 'id';
    protected $appends = ['telefoneFormatado'];
    
    const CREATED_AT = 'data_criacao';
    const UPDATED_AT = null;

    protected $fillable = ['id', 'nome', 'email', 'telefone', 'mensagem', 'path', 'ip', 'data_criacao'];

    public function getTelefoneFormatadoAttribute() 
    {    
        $telefoneFormatado = preg_replace('/[^0-9]/', '', $this->telefone);
        $matches = [];
        preg_match('/^([0-9]{2})([0-9]{4,5})([0-9]{4})$/', $telefoneFormatado, $matches);
        if ($matches) {
            return '('.$matches[1].') '.$matches[2].'-'.$matches[3];
        }
        
        return $this->telefone; 
    }
}
