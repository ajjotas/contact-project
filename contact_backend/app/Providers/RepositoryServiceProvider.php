<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repository\EloquentRepositoryInterface;
use App\Repository\ContatoRepositoryInterface;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\ContatoRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(ContatoRepositoryInterface::class, ContatoRepository::class);               
    }

    public function boot()
    {
    }
}
