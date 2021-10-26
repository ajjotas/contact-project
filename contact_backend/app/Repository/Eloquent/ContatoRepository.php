<?php

namespace App\Repository\Eloquent;

use App\Contato;
use App\Repository\ContatoRepositoryInterface;

class ContatoRepository extends BaseRepository implements ContatoRepositoryInterface
{
   public function __construct(Contato $model)
   {
       parent::__construct($model);
   }
}