<?php

$app['skillGroupCollection'] = $app->share(function ($app) {
    if (isset($app['config.system.skillGroups'])) {
        $factory = new \Mikron\HubBack\Infrastructure\Factory\ConceptsFactory();
        $skillGroupCollection = $factory->createSkillGroupCollectionFromListOfObjects($app['config.system.skillGroups']);
    } else {
        $skillGroupCollection = [];
    }

    return $skillGroupCollection;
});

$app['skills'] = $app->share(function ($app) {
    if (isset($app['config.system.skills'])) {
        $factory = new \Mikron\HubBack\Infrastructure\Factory\ConceptsFactory();
        $skillList = $factory->createSkillsFromConfig($app['config.system.skills'], $app['skillGroupCollection']);
    } else {
        $skillList = [];
    }

    return $skillList;
});
