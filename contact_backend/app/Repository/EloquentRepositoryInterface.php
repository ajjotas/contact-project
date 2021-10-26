<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface EloquentRepositoryInterface
{
   public function create(array $payload): ?Model;              
}
