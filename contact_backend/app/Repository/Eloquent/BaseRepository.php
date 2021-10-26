<?php   

namespace App\Repository\Eloquent;   

use App\Repository\EloquentRepositoryInterface; 
use Illuminate\Database\Eloquent\Model;   
use Illuminate\Database\Eloquent\Collection;

class BaseRepository implements EloquentRepositoryInterface 
{        
     protected $model;       
    
    public function __construct(Model $model)     
    {         
        $this->model = $model;
    }

    public function create(array $payload): ?Model
    {
        return $this->model->create($payload);
    }         
}