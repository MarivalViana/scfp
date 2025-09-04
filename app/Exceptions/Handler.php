<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class Handler extends ExceptionHandler
{
    /**
     * Uma lista dos tipos de exceções que não devem ser reportadas.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        // Adicione aqui exceções que você não quer que sejam logadas,
        // como `\Illuminate\Auth\AuthenticationException`
    ];

    /**
     * Registra as exceções para serem reportadas.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Renderiza a exceção em uma resposta HTTP.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // Intercepta e trata a exceção de "Model não encontrado"
        if ($exception instanceof ModelNotFoundException) {
            // Verifica se a requisição é para uma API
            if ($request->is('api/*')) {
                return new JsonResponse([
                    'error' => 'Recurso não encontrado.',
                ], 404); // Status 404 Not Found
            }
        }

        // Intercepta e trata a exceção de banco de dados
        if ($exception instanceof QueryException) {
            // Verifica se a requisição é para uma API
            if ($request->is('api/*')) {
                // Código de erro 23000 é para violação de chave de integridade (ex: email duplicado)
                if ($exception->getCode() === '23000') {
                    return new JsonResponse([
                        'error' => 'Ocorreu um erro de integridade de dados (e.g., chave duplicada).',
                    ], 409); // Status 409 Conflict
                }

                // Outros erros de consulta SQL
                return new JsonResponse([
                    'error' => 'Ocorreu um erro na consulta ao banco de dados.',
                ], 500); // Status 500 Internal Server Error
            }
        }

        // Retorna o comportamento padrão para todas as outras exceções
        return parent::render($request, $exception);
    }
}
