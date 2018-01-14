<?php
namespace KS;

class Exchange extends AbstractSocketDaemon
{
    protected $orderBook;

    protected function init()
    {
        $this->orderBook = new OrderBook($this->config);
    }

    protected function processMessage(string $msg) : ?string
    {
        // HTTP-ish Protocol implementation
        if ($msg === '') {
            throw new ConnectionCloseException();
        }

        $msg = json_decode($msg, true);
        if (!$msg) {
            throw new UserMessageException("Sorry, your input was not intelligible JSON. Please try again.", 400);
        }

        $cmd = $msg['data'];
        $resource = $cmd['attributes']['resource'];
        $method = $cmd['attributes']['method'];
        if ($resource['type'] === 'orders') {
            if ($method === 'post') {
                $this->orderBook->createOrder($resource);
                $response = [
                    'type' => 'exchange-responses',
                    'attributes' => [
                        'status' => 201,
                        'title' => "Created",
                    ]
                ];
            } elseif ($method === 'get') {
                // Might throw exception
                $order = $this->orderBook->getOrder($resource['id']);
                $response = [
                    'type' => 'exchange-responses',
                    'attributes' => [
                        'status' => 200,
                        'title' => 'OK',
                        'resource' => $order
                    ]
                ];
            } else {
                throw new UnknownMethodException("Don't know how to process method `$method` for resources of type `$resource[type]`", 400);
            }
        } else {
            throw new UnknownMethodException("Don't know how to handle resources of type `$resource[type]`", 400);
        }

        return json_encode([
            'data' => [
                'type' => 'exchange-response',
                'attributes' => [
                    'payload' => $response,
                ]
            ]
        ]);
    }

    protected function formatError(\Throwable $e) : string
    {
        return json_encode([
            'errors' => [
                [
                    'status' => $e->getCode(),
                    'title' => 'Error',
                    'detail' => $e->getMessage(),
                ]
            ]
        ]);
    }
}

