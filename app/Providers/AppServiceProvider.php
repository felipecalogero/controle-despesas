<?php

namespace App\Providers;

use App\Core\Modules\Despesas\Application\Presenters\Outputs\DespesaPresenter;
use App\Infrastructure\Repositories\QueryCadastroRepository;
use App\Infrastructure\Repositories\QueryDespesaRepository;
use App\Infrastructure\Repositories\QueryFinanceiroRepository;
use App\Infrastructure\Repositories\QueryLoginRepository;
use App\Infrastructure\Repositories\QuerySocialRepository;
use App\Infrastructure\Repositories\QueryUsuarioRepository;
use Core\Modules\Despesas\Domain\Gateways\DespesaGateway;
use Core\Modules\Financeiro\Domain\Gateway\FinanceiroGateway;
use Core\Modules\Social\Domain\Gateway\SocialGateway;
use Core\Modules\Usuario\Cadastro\Domain\Gateways\CadastroGateway;
use Core\Modules\Usuario\Domain\Gateway\UsuarioGateway;
use Core\Modules\Usuario\Login\Domain\Gateways\LoginGateway;
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
        $this->app->bind(FinanceiroGateway::class, QueryFinanceiroRepository::class);
        $this->app->bind(UsuarioGateway::class, QueryUsuarioRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
