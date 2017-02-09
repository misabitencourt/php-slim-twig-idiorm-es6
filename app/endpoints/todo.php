<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/', function(Request $request, Response $response) {
    return '<script>window.location = "/todos"</script>';
});

$app->get('/todos', function (Request $request, Response $response) use ($twig) {
    $session = $request->getAttribute('session');
    $todos = ORM::for_table('todo')->limit(10)
                                   ->order_by_desc('id')
                                   ->find_many();
    $message = empty($_SESSION['flash']) ? '' : $_SESSION['flash'];
    $_SESSION['flash'] = null;

    return $twig->loadTemplate('todo/index.html')
                ->render([ 'todos' => $todos, 'message' => $message ]);
});

$app->get('/todo/new', function (Request $request, Response $response) use ($twig) {
    return $twig->loadTemplate('todo/new.html')
                ->render([]);
});

$app->get('/todo/{id}/edit', function (Request $request, Response $response) use ($twig) {
    $id = $request->getAttribute('id');
    $todo = ORM::for_table('todo')->find_one($id);

    return $twig->loadTemplate('todo/edit.html')
                ->render(['todo' => $todo]);
});

$app->get('/todo/{id}/delete', function (Request $request, Response $response) use ($twig) {
    $id = $request->getAttribute('id');
    $todo = ORM::for_table('todo')->find_one($id);
    $todo->delete();
    $_SESSION['flash'] = 'Item excluído com sucesso';

    return '<script>window.location = "/todos";</script>';
});

$app->post('/todo', function (Request $request, Response $response) use ($twig) {
    $body = $request->getParsedBody();
    $todo = ORM::for_table('todo')->create();
    $todo->description = $body['description'];
    $todo->done = false;
    $todo->save();
    $_SESSION['flash'] = 'Item salvo com sucesso';

    return '<script>window.location = "/todos";</script>';
});

$app->post('/todo/{id}', function (Request $request, Response $response) use ($twig) {
    $id = $request->getAttribute('id');
    $body = $request->getParsedBody();
    $todo = ORM::for_table('todo')->find_one($id);
    $todo->description = $body['description'];
    $todo->save();
    $_SESSION['flash'] = 'Item atualizado com sucesso';

    return '<script>window.location = "/todos";</script>';
});
