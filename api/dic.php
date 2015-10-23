<?php

$app['skillGroups'] = $app->share(function ($app) {

    if (isset($app['config.system.skillGroups'])) {
        $factory = new \Mikron\HubBack\Infrastructure\Factory\ConceptsFactory();

        $skillGroupsConfig = $app['config.system.skillGroups'];

        $skillGroupList = $factory->createSkillGroupsFromConfig($skillGroupsConfig);
    } else {
        $skillGroupList = [];
    }

    return $skillGroupList;
});

$app['skills'] = $app->share(function ($app) {

    if (isset($app['config.system.skills'])) {
        $factory = new \Mikron\HubBack\Infrastructure\Factory\ConceptsFactory();

        $skillsConfig = $app['config.system.skills'];

        $skillList = $factory->createSkillsFromConfig($skillsConfig);
    } else {
        $skillList = [];
    }

    return $skillList;
});
