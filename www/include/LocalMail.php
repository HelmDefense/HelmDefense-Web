<?php
require_once "Mail.php";

class LocalMail {
	private static $smtp = null;

	static function init() {
		self::$smtp = Mail::factory("smtp", array(
				"debug" => true,
				"host" => Utils::config("smtp.host"),
				"port" => Utils::config("smtp.port"),
				"auth" => true,
				"username" => Utils::config("smtp.username"),
				"password" => Utils::config("smtp.password")
		));
	}

	static function mail($to, $subject, $message, $additional_headers = null, $debug = false) {
		if (is_null(self::$smtp))
			self::init();
		$headers = array("Mime-Version" => "1.0;", "Content-Type" => "text/html; charset=\"ISO-8859-1\";", "Content-Transfer-Encoding" => "7bit;");
		if (!is_null($additional_headers)) {
			foreach (explode("\r\n", $additional_headers) as $header) {
				$h = explode(": ", $header);
				$headers[$h[0]] = $h[1];
			}
		}
		$headers["To"] = $to;
		$headers["Subject"] = $subject;
		ob_start();
		$mail = self::$smtp->send($to, $headers, $message);
		$debugOutput = htmlspecialchars(ob_get_clean());
		if ($debug) {
			echo "<pre>$debugOutput</pre>";
			if (PEAR::isError($mail))
				echo "<pre>" . $mail->getMessage() . "</pre>";
		}
		return !PEAR::isError($mail);
	}
}
