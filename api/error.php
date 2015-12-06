<?php

$app->error(function (Exception $exception) use ($app) {
    return "There has been an error: ".$exception->getMessage();
});
