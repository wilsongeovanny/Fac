<?php


	function enviarEmail($email, $nombre, $asunto, $cuerpo){
		
		//require_once 'PHPMailer/PHPMailerAutoload.php';
		
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'tls'; //Modificar
		$mail->Host = 'smtp.gmail.com'; //Modificar
		$mail->Port = 587; //Modificar
		
		$mail->Username = 'gadmantenimiento1@gmail.com'; //Modificar
		$mail->Password = 'Mantenimiento[1000]'; //Modificar
		
		$mail->setFrom('gadmantenimiento1@gmail.com', 'GAD LATACUNGA'); //Modificar
		$mail->addAddress($email, $nombre);
		
		$mail->Subject = $asunto;
		$mail->Body    = $cuerpo;
		$mail->IsHTML(true);

		/* ------------------------- SEGURIDAD */
	$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
/* ------------------------- SEGURIDAD */
		
		if($mail->send())
		return true;
		else
		return false;
	}





?>