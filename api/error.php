<?php

$app->error(function (\Exception $exception) use ($app) {
    $result = [
        "title" => "Error",
        "description" => "There has been an error",
        "content" => []
    ];

    if ($app['config']['debug']) {
        $result['content'][] = $exception->getMessage();
    } else {
        if($exception instanceof \Mikron\HubBack\Domain\Exception\ExceptionWithSafeMessage) {
            $result['content'][] = $exception->getSafeMessage();
        }
    }

    return $app->json($result);
});
