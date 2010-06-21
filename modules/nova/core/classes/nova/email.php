<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Email class
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 */

# TODO: uncomment $result return in install_register

abstract class Nova_Email
{
	/**
	 * Send the installation registration email.
	 *
	 * @param	array 	an array of items to use in the email
	 * @return	object	swift mailer object
	 */
	public static function install_register(array $data)
	{
		// set up the mailer
		$mailer = self::setup();
		
		// get a new instance of SwiftMailer
		$message = Swift_Message::newInstance();
		
		// set the data for the message
		$message->setSubject('Nova Registration');
		$message->setFrom('nova.registration@example.com');
		$message->setTo(array('anodyne.nova@gmail.com'));
		$message->setBody($data['message']);
		
		// send the message
		$result = $mailer->send($message);
		
		//return $result;
	}
	
	/**
	 * Sets up the SwiftMailer class with the appropriate transport, creates the mailer and returns
	 * the instance of the mailer.
	 *
	 * @uses	Kohana::config
	 * @return	object	an instance of the mailer object
	 */
	protected static function setup()
	{
		// get the email config
		$email = Kohana::config('email');
		
		// create the transport based on what's in the email config file
		switch ($email->type)
		{
			case 'mail':
				$transport = Swift_MailTransport::newInstance();
				break;
				
			case 'sendmail':
				$transport = Swift_SendmailTransport::newInstance($email->sendmail_path);
				break;
				
			case 'smtp':
				$transport = Swift_SmtpTransport::newInstance($email->smtp_server, $email->smtp_port)
					->setUsername($email->smtp_username)
					->setPassword($email->smtp_password);
				
				break;
		}
		
		// create the mailer
		$mailer = Swift_Mailer::newInstance($transport);
		
		return $mailer;
	}
} // End Email