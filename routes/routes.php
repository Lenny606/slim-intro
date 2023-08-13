<!-- controller for routes CRUD operations -->
<?php
use Psr\Http\Message\ResponseInterface as Response; //access to request / response
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create(); 

$app->get('/users/all', function(Request $request, Response $response){
    $sql_query = 'SELECT * FROM `test_table`';

    try {
        $db = new DB();
        $conn = $db->connect();

        $stmnt = $conn->query($sql_query);
        $data = $stmnt->fetchAll(PDO::FETCH_OBJ);

        $db = null;

        $response->getBody()->write(json_encode($data));

        return $response->withHeader('Content-Type', 'application/')->withStatus(200);

    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));  //return response with error message

        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    };
});

$app->get('/users/{id}', function(Request $request, Response $response, array $args){

    $id = $args['id'];

    $sql_query = 'SELECT * FROM `test_table` WHERE `id` = ' . $id;

    try {
        $db = new DB();
        $conn = $db->connect();

        $stmnt = $conn->query($sql_query);
        $data = $stmnt->fetchAll(PDO::FETCH_OBJ);

        $db = null;

        $response->getBody()->write(json_encode($data));

        return $response->withHeader('Content-Type', 'application/')->withStatus(200);

    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));  //return response with error message

        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    };
});

//POST request , accepts json in the body of the request {name: value, email: value}
$app->post('/users/add', function(Request $request, Response $response, array $args){
    //prepare parameters
    $name = $request->getParam('name');
    $email = $request->getParam('email');
    
    $sql_query = 'INSERT INTO `test_table` (email, name) VALUES (:email, :name)'; //values needs to be bound to parameters
    
    try {
        $db = new DB();
        $conn = $db->connect();

        //bindings goes here with prepare() function
        $stmnt = $conn->prepare($sql_query);
        $stmnt->bindValue(':email', $email);
        $stmnt->bindValue(':name', $name);
        $data = $stmnt->execute();        

        $db = null;

        $response->getBody()->write(json_encode($data));

        return $response->withHeader('Content-Type', 'application/')->withStatus(200);

    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));  //return response with error message

        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    };
});

// DELETE similar ass adding with post request
$app->delete('/users/{id}', function(Request $request, Response $response, array $args){
   
    $id = $args['id'];

    $sql_query = 'DELETE FROM test_table WHERE id = $id';
    
    try {
        $db = new DB();
        $conn = $db->connect();

        $stmnt = $conn->prepare($sql_query);
        $data = $stmnt->execute();        

        $db = null;

        $response->getBody()->write(json_encode($data));

        return $response->withHeader('Content-Type', 'application/')->withStatus(200);

    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));  //return response with error message

        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    };
});