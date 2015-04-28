<?php

/** Post request */
// array for JSON response
$response = array();

$fields = array();
$fields['name']=$_POST['name'];
$fields['mail']=$_POST['mail'];
$fields['subject']=$_POST['subject'];
$fields['message']=$_POST['message'];
$fields['idObject']=$_POST['idObject'];

$receiverusername = "";
$receivermail= "";

// check for required fields
if (isset($_POST['name']) && isset($_POST['mail']) && isset($_POST['subject']) && isset($_POST['message'])) {

    $senderusername = $_POST['name'];
    $sendermail = $_POST['mail'];
    $messagesubject = $_POST['subject'];
    $messagecontent = $_POST['message'];
    $idobject=$_POST['idObject'];

    // include db connect class
    require '../controller/db_connect.php';

// connecting to db
    $db = new DB_CONNECT();
    mysql_query('SET CHARACTER SET utf8');

    // mysql update row with matched pid
    $result = mysql_query("SELECT nameUser,mailUser FROM smUser INNER JOIN smObject ON smUser.idUser = smObject.smUser_idUser WHERE idObject=$idobject") or die(mysql_error());
    // check for empty result
    if ($result) {
        $row = $row = mysql_fetch_array($result);
        $receiverusername=$row["nameUser"];
        $receivermail=$row["mailUser"];
    }
    else{
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
$htmlmail=file_get_contents('mail-template.html');
//$senderusername = 'Louis M';
//$receiverusername = 'Marin B';
//$messagesubject = 'Demande de prêt d\'objet';
/*$messagecontent = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam aliquam tincidunt ornare. Sed sollicitudin turpis eu ex auctor, tincidunt elementum turpis sodales. Phasellus condimentum non tellus id sagittis. In porta aliquam leo eget sodales. Etiam commodo elit nec faucibus dictum. Praesent sed ultricies nulla, scelerisque faucibus dolor. Nam dapibus, risus at auctor elementum, justo felis tristique orci, ac aliquet urna eros tincidunt ante. Proin laoreet aliquam dignissim. Mauris maximus nibh lobortis neque auctor, ut consequat ex congue. Proin ultricies lectus eu augue viverra consequat. Mauris ut enim vel arcu interdum mattis non mattis augue. Morbi vitae erat eu tortor feugiat viverra. Integer placerat lectus ut massa varius molestie id in leo. Nullam in erat non purus pharetra vehicula at eget augue. Quisque cursus ante mauris, quis fringilla leo iaculis sed.
Praesent neque odio, convallis quis ligula fringilla, auctor imperdiet mi. Nulla nibh sapien, consectetur viverra posuere a, lobortis vel ipsum. Vestibulum tincidunt consequat diam, blandit fermentum eros accumsan ac. Praesent dapibus dolor viverra malesuada volutpat. Nam nibh orci, consequat nec purus sed, gravida molestie quam. Cras semper tristique arcu ac auctor. Fusce pretium in diam ac gravida. Mauris gravida varius dui, eu elementum ante. Fusce maximus vitae augue a cursus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vivamus lacinia commodo eros a sollicitudin. Curabitur consequat at dui eu commodo.";
*/
$htmlmail = str_replace('%receiverusername%',$receiverusername, $htmlmail);
$htmlmail = str_replace('%senderusername%',$senderusername, $htmlmail);
$htmlmail = str_replace('%messagesubject%',$messagesubject, $htmlmail);
$htmlmail = str_replace('%messagecontent%',$messagecontent, $htmlmail);


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
//$mail->addAttachment('images/phpmailer_mini.png');

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
}}
else{
    $response["success"] = 0;
    $response["message"] = "Erreur";

    echo json_encode($response);
}
