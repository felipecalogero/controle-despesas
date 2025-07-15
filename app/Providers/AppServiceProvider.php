<?php

namespace App\Providers;

use App\Core\Modules\Despesas\Application\Presenters\Outputs\DespesaPresenter;
use Core\Modules\Despesas\Application\UseCases\ListarDespesasUseCase;
use Core\Modules\Despesas\Domain\Gateways\DespesaGateway;
use App\Infrastructure\Repositories\QueryDespesaRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DespesaGateway::class, QueryDespesaRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
