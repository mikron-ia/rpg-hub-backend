<?php

$app['skillGroupCollection'] = $app->share(function ($app) {
    $factory = new \Mikron\HubBack\Infrastructure\Factory\ConceptsFactory();

    if (isset($app['config.system.skillGroups'])) {
        $skillGroupCollection = $factory->createSkillGroupCollectionFromListOfObjects($app['config.system.skillGroups']);
    } else {
        $skillGroupCollection = $factory->createSkillGroupCollectionFromListOfObjects([]);
    }

    return $skillGroupCollection;
});

$app['skills'] = $app->share(function ($app) {
    $factory = new \Mikron\HubBack\Infrastructure\Factory\ConceptsFactory();

    if (isset($app['config.system.skills'])) {
        $skillList = $factory->createSkillCollectionFromList($app['config.system.skills'], $app['skillGroupCollection']);
    } else {
        $skillList = $factory->createSkillCollectionFromList([], $app['skillGroupCollection']);
    }

    return $skillList;
});
