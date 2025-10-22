<?php

namespace App\Providers;

use App\Core\Modules\Despesas\Application\Presenters\Outputs\DespesaPresenter;
use App\Infrastructure\Repositories\QueryCadastroRepository;
use App\Infrastructure\Repositories\QueryDespesaRepository;
use App\Infrastructure\Repositories\QueryLoginRepository;
use App\Infrastructure\Repositories\QuerySocialRepository;
use Core\Modules\Despesas\Domain\Gateways\DespesaGateway;
use Core\Modules\Usuario\Cadastro\Application\Domain\Gateways\CadastroGateway;
use Core\Modules\Usuario\Login\Domain\Gateways\LoginGateway;
use Core\Modules\Usuario\Social\Domain\Gateways\SocialGateway;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DespesaGateway::class, QueryDespesaRepository::class);
        $this->app->bind(LoginGateway::class, QueryLoginRepository::class);
        $this->app->bind(CadastroGateway::class, QueryCadastroRepository::class);
        $this->app->bind(SocialGateway::class, QueryCadastroRepository::class);
        $this->app->bind(SocialGateway::class, QuerySocialRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
