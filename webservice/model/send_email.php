<?php

header('Content-Type: text/html; charset=utf-8');

/** Post request */
// array for JSON response
$response = array();

$fields = array();
$fields['name'] = $_POST['name'];
$fields['mail'] = $_POST['mail'];
$fields['subject'] = $_POST['subject'];
$fields['message'] = $_POST['message'];
$fields['idObject'] = $_POST['idObject'];

$receiverusername = "";
$receivermail = "";


// check for required fields
if (isset($_POST['name']) && isset($_POST['mail']) && isset($_POST['subject']) && isset($_POST['message'])) {

    // include db connect class
    require '../controller/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();
    mysql_query('SET CHARACTER SET utf8');

    $senderusername = mysql_real_escape_string($_POST['name']);
    $sendermail = mysql_real_escape_string($_POST['mail']);
    $messagesubject = mysql_real_escape_string($_POST['subject']);
    $messagecontent = mysql_real_escape_string($_POST['message']);
    $idobject = intval($_POST['idObject']);

    $messagecontent = utf8_encode($messagecontent);
    $messagesubject = utf8_encode($messagesubject);

    // mysql update row with matched pid
    $result = mysql_query("SELECT nameUser,mailUser FROM smUser INNER JOIN smObject ON smUser.idUser = smObject.smUser_idUser WHERE idObject=$idobject") or die(mysql_error());
    // check for empty result
    if ($result) {
        $row = $row = mysql_fetch_array($result);
        $receiverusername = $row["nameUser"];
        $receivermail = $row["mailUser"];
    } else {
        $response["success"] = 0;
        $response["message"] = "Erreur";

        echo json_encode($response);
    }


    /**
     * This example shows making an SMTP connection with authentication.
     */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
    date_default_timezone_set('Etc/UTC');

    require '../library/PHPMailer/PHPMailerAutoload.php';

//Variables
    $htmlmail = file_get_contents('mail-template.html');

    $htmlmail = str_replace('%receiverusername%', $receiverusername, $htmlmail);
    $htmlmail = str_replace('%senderusername%', $senderusername, $htmlmail);
    $htmlmail = str_replace('%messagesubject%', $messagesubject, $htmlmail);
    $htmlmail = str_replace('%messagecontent%', $messagecontent, $htmlmail);


//Create a new PHPMailer instance
    $mail = new PHPMailer;
//Tell PHPMailer to use SMTP
    $mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
    $mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';
//Encoding
    $mail->CharSet = 'UTF-8';
//Set the hostname of the mail server
    $mail->Host = "sharemee.com";
//Set the SMTP port number - likely to be 25, 465 or 587
    $mail->Port = 465;
//Whether to use SMTP authentication
    $mail->SMTPAuth = true;
//Username to use for SMTP authentication
    $mail->Username = "contact@sharemee.com";
//Password to use for SMTP authentication
    $mail->Password = "s1h2a3r4e5m6e7e8";
    $mail->SMTPSecure = 'ssl';
//Set who the message is to be sent from
    $mail->setFrom('contact@sharemee.com', 'ShareMee');
//Set an alternative reply-to address
    $mail->addReplyTo($sendermail, $senderusername);
//Set who the message is to be sent to
    $mail->addAddress($receivermail, '');
//Set the subject line
    $mail->Subject = $messagesubject;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('mail-template.html'), dirname(__FILE__));
    $mail->msgHTML($htmlmail);
//Replace the plain text body with one created manually
    $mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('../view/Convention_de_pret_ShareMee.pdf');

//send the message, check for errors
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
        $response["success"] = 0;
        $response["message"] = "Erreur";
        echo json_encode($response);
    } else {
        echo "Message sent!";
        $response["success"] = 1;
        $response["message"] = "Email envoyé";

        echo json_encode($response);
    }
} else {
    $response["success"] = 0;
    $response["message"] = "Erreur, champs manquants";

    echo json_encode($response);
}
