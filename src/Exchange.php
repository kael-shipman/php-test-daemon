<?php
namespace KS;

class Exchange extends AbstractMessageDaemon
{
    protected function processMessage(string $msg) : ?string
    {
        // If we send an empty line, then the connection is over
        if ($msg === '') {
            throw new ConnectionCloseException();
        } elseif ($msg === 'shutdown') {
            throw new ShutdownException();
        }

        $msg = json_decode($msg);
        if (!$msg) {
            throw new UserMessageException("Sorry, your input was not intelligible JSON. Please try again.", 401);
        }

        $response = [
            'data' => [
                'type' => 'payload',
                'id' => date('YmdHis'),
                'attributes' => [
                    'response' => json_encode($msg, JSON_PRETTY_PRINT)
                ]
            ]
        ];
        return json_encode($response);
    }
}

