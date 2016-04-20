<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Access-Control-Allow-Origin');

require "bootstrap.php";

$app = new \Slim\App;

$app->map(['GET', 'JSONP'], '/task/{id}', function($request, $response, $args) use ($entityManager)
{
    $id = $args['id'];
    $task = $entityManager->find('Task', $id);

    $response->withHeader('Access-Control-Allow-Origin', '*');
    if ($task === null) {
        return $response->withStatus(404, "Could not find task.");
    }
    return $response->withJson($task);
});

$app->post('/task/{id}', function($request, $response, $args) use ($entityManager)
{
    $id = $args['id'];
    $task = $entityManager->find('Task', $id);

    $updatedFields = $request->getParsedBody();
    foreach ($updatedFields as $fieldName => $newvalue)
    {
        $updateMethod = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $fieldName)));
        if ( method_exists($task, $updateMethod) ) {
            $task->$updateMethod($newvalue);
        } else {
            return $response->withStatus(400);
        }
    }

    if ($task === null)
    {
        return $response->withStatus(404, "Could not find task.");
    }
    $entityManager->flush();
    return $response->withJson($task);
});

$app->delete('/task/{id}', function($request, $response, $args) use ($entityManager)
{
    $id = $args['id'];
    $task = $entityManager->find('Task', $id);

    if ($task === null) {
        return $response->withStatus(404, "Could not find task.");
    }

    $entityManager->remove($task);
    $entityManager->flush();

    return $response->withJson($task);
});

$app->get('/task/', function($request, $response, $args) use ($entityManager)
{
    $taskRepository = $entityManager->getRepository('Task');
    $tasks = $taskRepository->findAll();

    return $response->withJson($tasks);
});

$app->put('/task/', function($request, $response, $args) use ($entityManager)
{
    $task = new Task();
    $updatedFields = $request->getParsedBody();
    foreach ($updatedFields as $fieldName => $newvalue)
    {
        $updateMethod = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $fieldName)));
        if ( method_exists($task, $updateMethod) ) {
            $task->$updateMethod($newvalue);
        } else {
            return $response->withStatus(400);
        }
    }

    $entityManager->persist($task);
    $entityManager->flush();
    return $response->withJson($task);
});

$app->run();