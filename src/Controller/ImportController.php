<?php
/**
 * This file is part of bigperson/laravel-exchange1c package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Bigperson\LaravelExchange1C\Controller;

use Bigperson\Exchange1C\Exceptions\Exchange1CException;
use Bigperson\Exchange1C\Services\CatalogService;
use Bigperson\LaravelExchange1C\Jobs\CatalogServiceJob;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

/**
 * Class ImportController.
 */
class ImportController extends Controller
{
    /**
     * @var Log
     */
    private $logger;

    /**
     * ImportController constructor.
     */
    public function __construct()
    {
        if (config('exchange1c.log_channel', false)) {
            $this->logger = Log::channel(config('exchange1c.log_channel'));
        }
    }

    /**
     * @param Request        $request
     * @param CatalogService $service
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function request(Request $request, CatalogService $service)
    {
        $mode = $request->get('mode');
        $type = $request->get('type');
        $this->log('requsest: '.print_r($request->all(), true));

        try {
            if ($type == 'catalog') {
                if (!method_exists($service, $mode)) {
                    throw new Exchange1CException('not correct request, class ExchangeCML not found');
                }

                if ($mode === 'init' or $mode === 'checkauth' or $mode === 'file') {
                    $response = $service->$mode();
                    $this->log(sprintf(
                        'New init request, type: %s, mode: %s, response: %s',
                        $type,
                        $mode,
                        $response
                    ));

                    return response($response, 200, ['Content-Type', 'text/plain']);
                }

                CatalogServiceJob::dispatch(
                    $request->all(),
                    $request->session()->all()
                )
                    ->onQueue(config('exchange1c.queue'));
                $response = "success\n";

                $this->log(sprintf(
                    'New request, type: %s, mode: %s, response: %s. CatalogServiceJob is started',
                    $type,
                    $mode,
                    $response
                ));

                return response($response, 200, ['Content-Type', 'text/plain']);
            } elseif ($type === 'sale') {
                $response = $service->checkauth();
                $this->log(sprintf(
                    'New sale request, type: %s, mode: %s, response: %s. Logic for sale type not released!',
                    $type,
                    $mode,
                    $response
                ));

                return response($response, 200, ['Content-Type', 'text/plain']);
            } else {
                $message = sprintf('Logic for method %s not released', $type);
                $this->log($message, 'error');

                throw new \LogicException($message);
            }
        } catch (Exchange1CException $e) {
            $this->log(
                "exchange_1c: failure \n".$e->getMessage()."\n".$e->getFile()."\n".$e->getLine()."\n",
                'error'
            );

            $response = "failure\n";
            $response .= $e->getMessage()."\n";
            $response .= $e->getFile()."\n";
            $response .= $e->getLine()."\n";

            return response($response, 500, ['Content-Type', 'text/plain']);
        }
    }

    private function log(string $message, string $type = 'info'): void
    {
        if (!$this->logger) {
            return;
        }

        $this->logger->$type($message);
    }
}
