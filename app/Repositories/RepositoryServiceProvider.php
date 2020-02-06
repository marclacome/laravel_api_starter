<?php

namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * register
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\ApiModel1RepositoryInterface',
            'App\Repositories\ApiModel1Repository'
        );
    }
}
