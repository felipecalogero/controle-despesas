<?php

namespace Tests\Unit\Modules\Despesa;

use App\Models\Despesa;
use Core\Modules\Despesas\Application\UseCases\AtualizarDespesaUseCase;
use Core\Modules\Despesas\Application\UseCases\CriarDespesaUseCase;
use Core\Modules\Despesas\Application\UseCases\DeletarDespesaUseCase;
use Core\Modules\Despesas\Application\UseCases\EditarDespesaUseCase;
use Core\Modules\Despesas\Application\UseCases\Inputs\AtualizarDespesaInput;
use Core\Modules\Despesas\Application\UseCases\Inputs\CriarDespesaInput;
use Core\Modules\Despesas\Application\UseCases\ListarDespesasUseCase;
use Core\Modules\Despesas\Domain\Entities\DespesaEntity;
use Core\Modules\Despesas\Domain\Exceptions\DespesaInvalidaException;
use Core\Modules\Despesas\Domain\Exceptions\DespesaNaoPodeSerFuturaException;
use Core\Modules\Despesas\Domain\Gateways\DespesaGateway;
use Core\Modules\Despesas\Domain\Rulesets\DespesaRuleSet;
use PHPUnit\Framework\TestCase;

class DespesaTest extends TestCase
{
    public function testCriarDespesaComSucesso()
    {
        $input = new CriarDespesaInput('Compra papel', 99.99, new \DateTime('2025-07-15'));

        $despesa = new DespesaEntity(null, $input->descricao, $input->valor, $input->data);

        $gateway = $this->createMock(DespesaGateway::class);
        $gateway->method('salvar')->willReturn($despesa);

        $ruleset = $this->createMock(DespesaRuleSet::class);
        $ruleset->expects($this->once())->method('apply');

        $useCase = new CriarDespesaUseCase($gateway, $ruleset);

        $output = $useCase->execute($input);

        $this->assertEquals('Compra papel', $output->dados['descricao']);
        $this->assertEquals(99.99, $output->dados['valor']);
        $this->assertEquals('2025-07-15', $output->dados['data']);
        $this->assertEquals('Despesa criada com sucesso.', $output->mensagem);
    }

    public function testCriarDespesaComDataFutura()
    {
        $this->expectException(DespesaNaoPodeSerFuturaException::class);

        $dataFutura = (new \DateTime())->modify('+5 days');

        $input = new CriarDespesaInput('Compra papel', 99.99, $dataFutura);

        $gateway = $this->createMock(DespesaGateway::class);
        $gateway->expects($this->never())->method('salvar');

        $ruleset = $this->createMock(DespesaRuleSet::class);
        $ruleset->method('apply')->willThrowException(
            new DespesaNaoPodeSerFuturaException()
        );

        $useCase = new CriarDespesaUseCase($gateway, $ruleset);

        $useCase->execute($input);
    }

    public function testBuscarDespesaInexistente()
    {
        $this->expectException(DespesaInvalidaException::class);

        $buscarDespesa = Despesa::query()->findOrFail(99);;

        $buscarDespesa->method('apply')->willThrowException(
            new DespesaNaoPodeSerFuturaException()
        );
    }

    public function testAtualizarDespesaComSucesso()
    {
        $input = new AtualizarDespesaInput(1, 'Atualizada', 200.0, new \DateTime('2025-07-20'));

        $despesa = new DespesaEntity($input->id, $input->descricao, $input->valor, $input->data);

        $gateway = $this->createMock(DespesaGateway::class);
        $gateway->method('atualizar')->willReturn($despesa);

        $ruleset = $this->createMock(DespesaRuleSet::class);
        $ruleset->expects($this->once())->method('apply');

        $useCase = new AtualizarDespesaUseCase($gateway, $ruleset);

        $output = $useCase->execute($input);

        $this->assertEquals(1, $output->id);
        $this->assertEquals('Atualizada', $output->dados['descricao']);
        $this->assertEquals(200.0, $output->dados['valor']);
        $this->assertEquals('2025-07-20', $output->dados['data']);
        $this->assertEquals('Despesa atualizada com sucesso', $output->mensagem);
    }

    public function testDeletarDespesaComSucesso()
    {
        $gateway = $this->createMock(DespesaGateway::class);
        $gateway->method('excluir')->with(1)->willReturn(true);

        $useCase = new DeletarDespesaUseCase($gateway);

        $output = $useCase->execute(1);

        $this->assertEquals('Despesa excluida com sucesso!', $output->mensagem);
    }

    public function testEditarDespesaComSucesso()
    {
        $despesa = new DespesaEntity(
            1,
            'Editar',
            80.0,
            new \DateTime('2025-07-10'),
            new \DateTime(),
            new \DateTime()
        );

        $gateway = $this->createMock(DespesaGateway::class);
        $gateway->method('buscar')->with(1)->willReturn($despesa);

        $useCase = new EditarDespesaUseCase($gateway);

        $output = $useCase->execute(1);

        $this->assertEquals(1, $output->id);
        $this->assertEquals('Editar', $output->descricao);
        $this->assertEquals(80.0, $output->valor);
        $this->assertEquals('2025-07-10', $output->data->format('Y-m-d'));
    }

    public function testListarDespesasComSucesso()
    {
        $despesas = [
            new DespesaEntity(1, 'D1', 50.0, new \DateTime('2025-07-01')),
            new DespesaEntity(2, 'D2', 100.0, new \DateTime('2025-07-02')),
        ];

        $gateway = $this->createMock(DespesaGateway::class);
        $gateway->method('listar')->willReturn($despesas);

        $useCase = new ListarDespesasUseCase($gateway);

        $output = $useCase->execute();

        $this->assertCount(2, $output->despesas);
        $this->assertEquals(150.0, $output->total);
    }
}
