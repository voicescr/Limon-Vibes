<?php

  use \Psr\Http\Message\ServerRequestInterface as Request;
  use \Psr\Http\Message\ResponseInterface as Response;

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  use Monolog\Logger;
  use Monolog\Handler\StreamHandler;

  $container = $app->getContainer();

  $container['logger'] = function ($c) {
      // create a log channel
      $log = new Logger('api');
      $log->pushHandler(new StreamHandler(__DIR__ . '/../logs/app.log', Logger::INFO));

      return $log;
  };

  // change * for the vinetsite.com 
  $app->add(function (Request $request, Response $response, $next) {
	$response = $next($request, $response);
	$response = $response->withHeader('Access-Control-Allow-Origin', '*')
		->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
		->withHeader('Access-Control-Allow-Methods', 'GET, POST');
	return $response;
  }); 

  $app->group('/email', function () use ($app) {
    $app->post('/send1', function (Request $request, Response $response){
        $mail = new PHPMailer(true);
        try {

            // request values 
            $nameFrom = $request ->getParam("name"); 
            $emailFrom = $request->getParam("email");
            $travelReason = $request->getParam("travelReason");
            $location = $request->getParam("location");
            $budget = $request->getParam("budget");


            // SMPT Settings 
            $mail->IsSMTP();
            $mail->SMTPDebug = 2;
            $mail->CharSet="UTF-8";
            $mail->Host = "srv05.infranetdns.com";  // smpt server 
            $mail->SMTPAuth = true; 
            $mail->SMTPSecure = 'SSL';    
            $mail->Username = "info@limonvibes.com"; // change this 
            $mail->Password = "omz(Ei{SIe4_"; // change this
            $mail->Port = 587;  

            // Email header 
            $mail->From = "info@limonvibes.com"; // Desde donde enviamos (Para mostrar)
            $mail->FromName = "Limon Vibes"; 
            //$mail->AddAddress("limonvibes506@gmail.com"); // correo al cual queremos que lleguen los submit del sitio
            $mail->AddAddress("rafa.sequeira93@gmail.com"); // correo al cual queremos que lleguen los submit del sitio

            // Email Body 
            $mail->IsHTML(true); // El correo se envía como HTML
            $mail->Subject = 'Nuevo Mensaje: Limon Vibes'; // A su gusto
            $body = "
            <div>
                <h2>Viaje Customizado<h2>
            </div>
            <div> 
            <p><strong>Nombre: </strong> $nameFrom</p> 
            <p><strong>Email: </strong> $emailFrom </p> 
            <p><strong>Travel Reason: </strong>$travelReason</p>
            <p><strong>Location: </strong>$location</p>
            <p><strong>Budget: </strong>$budget</p>

            </div>
            ";
           
            $mail->Body = $body; // Mensaje a enviar

            // Email sended 
            $exito = $mail->Send(); // Envía el correo.
            // headers
            $response = $response->withJson($exito);
            $response = $response->withHeader("Content-Type", "application/json");
			$response = $response->withStatus(201, "Sended");
            return $response;
        } catch (Exception $e) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }); 

        $app->post('/send2', function (Request $request, Response $response){
        $mail = new PHPMailer(true);
        try {

            // request values 
            $nameFrom = $request ->getParam("name"); 
            $emailFrom = $request->getParam("email");
            $message = $request->getParam("message");


            // SMPT Settings 
            $mail->IsSMTP();
            $mail->SMTPDebug = 2;
            $mail->CharSet="UTF-8";
            $mail->Host = "srv05.infranetdns.com";  // smpt server 
            $mail->SMTPAuth = true; 
            $mail->SMTPSecure = 'SSL';    
            $mail->Username = "info@limonvibes.com"; // change this 
            $mail->Password = "omz(Ei{SIe4_"; // change this
            $mail->Port = 587;  

            // Email header 
            $mail->From = "info@limonvibes.com"; // Desde donde enviamos (Para mostrar)
            $mail->FromName = "Limon Vibes"; 
            //$mail->AddAddress("limonvibes506@gmail.com"); // correo al cual queremos que lleguen los submit del sitio
            $mail->AddAddress("rafa.sequeira93@gmail.com"); // correo al cual queremos que lleguen los submit del sitio

            // Email Body 
            $mail->IsHTML(true); // El correo se envía como HTML
            $mail->Subject = 'Nuevo Mensaje Limon Vibes'; // A su gusto
            $body = "
            <div>
                <h2>En busca de un agente de servicio<h2>
            </div>
            <div> 
            <p><strong>Nombre: </strong> $nameFrom</p> 
            <p><strong>Email: </strong> $emailFrom </p> 
            <p><strong>Travel Reason: </strong>$message</p>
            </div>
            ";
           
            $mail->Body = $body; // Mensaje a enviar

            // Email sended 
            $exito = $mail->Send(); // Envía el correo.
            // headers
            $response = $response->withJson($exito);
            $response = $response->withHeader("Content-Type", "application/json");
			$response = $response->withStatus(201, "Sended");
            return $response;
        } catch (Exception $e) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }); 
  });

?>
