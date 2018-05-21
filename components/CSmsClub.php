<?php
namespace app\components;

use Exception;
use SimpleXMLElement;
use yii\base\Model;

class CSmsClub extends Model
{
	public $login;    // string User ID (phone number)
	public $password;        // string Password
	public $alphaName; // MAX 11 size  string, sender id (alpha-name) (as long as your alpha-name is not spelled out, it is necessary to use it)
	public $errors = array();

	private $subscriber;
	private $text;
	private $logList;

	public function init()
	{
		$this->login = \Yii::$app->params['CSmsClub']['login'];
		$this->password = \Yii::$app->params['CSmsClub']['password'];
		$this->alphaName = \Yii::$app->params['CSmsClub']['alphaName'];
		if ($this->login == '') {
			throw new Exception('error login in CSmsClub');
		}
		if ($this->password == '') {
			throw new Exception('error password in CSmsClub');
		}
		if ($this->alphaName == '') {
			throw new Exception('error alphaName in CSmsClub');
		}
	}

	public function sendSms($to, $text)
	{
		if (is_array($to) && count($to)) {
			foreach ($to as $toValue) {
				if ($this->testSubscriber($toValue)) {
					$this->subscriber .= ($this->subscriber != "" ? ";" : "") . $toValue;
				} else {
					$this->errors[] = "Неверный номер абонента:" . $toValue;
				}
			}
		} elseif (!is_array($to) && $to != "") {
			if ($this->testSubscriber($to)) {
				$this->subscriber = $to;
			} else {
				$this->errors[] = "Неверный номер абонента:" . $to;
			}
		}
		if (strlen($text) >= 469) {
			$this->errors[] = "максимальная длина сообщения: 469";
		}
		$this->logList['to'] = $this->subscriber;
		$this->logList['text'] = $this->text = $text;
		return $this->send();
	}

	private function testSubscriber($to)
	{
		return preg_match("/^([+]?[0-9]{12})$/", $to);
	}

	private function send()
	{
		$result = false;
		$messagesId = array();
		if (!count($this->errors)) {
			$this->logList['responce_xml'] = $xml = "<?xml version='1.0' encoding='utf-8'?><request_sendsms><username><![CDATA[" . $this->login . "]]></username><password><![CDATA[" . $this->password . "]]></password><from><![CDATA[" . $this->alphaName . "]]></from><to><![CDATA[" . $this->subscriber . "]]></to><text><![CDATA[" . $this->text . "]]></text></request_sendsms>";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://gate.smsclub.mobi/xml/');
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: text/xml; charset=utf-8'));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($ch, CURLOPT_SSLVERSION, 1);
			curl_setopt($ch, CURLOPT_CRLF, true);

			$curlResult = curl_exec($ch);
			if (curl_errno($ch)) {
				$this->logList['error_curl'] = curl_error($ch);
				$this->errors[] = "Ошибка CUrl";
			}
			curl_close($ch);
			if ($curlResult) {
				libxml_use_internal_errors(true);
				try {
					$this->logList['c_result'] = $curlResult;
					$xml = new SimpleXMLElement($curlResult);
					$this->logList['status'] = $status = (isset($xml->status) ? $xml->status : "");
					$this->logList['statusText'] = $statusText = (isset($xml->text) ? $xml->text : "");
					if (isset($xml->ids->mess) && count($xml->ids->mess)) {
						foreach ($xml->ids->mess as $id) {
							$messagesId[] = $id;
						}
					}
					$this->logList['messagesId'] = implode(",", $messagesId);
					if ($status == "OK") {
						$result = true;
					} else {
						$this->errors[] = $statusText;
					}
				} catch (Exception $e) {
					\Yii::error($e->getMessage() . "\n" . $curlResult);
				}
			}
		}
		$this->processLogs();
		return $result;
	}
	/*
	 * Логирование
	 */
	protected function processLogs()
	{
		$textLog = "";
		if (count($this->logList)) {
			foreach ($this->logList as $key => $value) {
				$textLog .= $key . " -> " . $value . "\n";
			}
		}
		if (count($this->errors)) {
			foreach ($this->errors as $error) {
				$textLog .= "error -> " . $error . "\n";
			}
		}

		$logFile = \Yii::getAlias('@app/runtime') . "/log_SMS_club.log";
//		var_dump($logFile);die();
		$fp = @fopen($logFile, 'a');
		@flock($fp, LOCK_EX);
		if (@filesize($logFile) > 102400 * 1024) {
			@fputs($fp, '-----Start log at ' . date('d-m-Y H:i:s') . '------' . "\n");
			@fputs($fp, $textLog);
			@fputs($fp, '-----End log at ' . date('d-m-Y H:i:s') . '--------' . "\n\n");
			@flock($fp, LOCK_UN);
			@fclose($fp);
		} else {
			@fputs($fp, '-----Start log at ' . date('d-m-Y H:i:s') . '------' . "\n");
			@fputs($fp, $textLog);
			@fputs($fp, '-----End log at ' . date('d-m-Y H:i:s') . '--------' . "\n\n");
			@flock($fp, LOCK_UN);
			@fclose($fp);
		}
	}

	/**
	 * @param int $length
	 * @return string
	 */
	public static function generateSMSCode($length = 10)
	{
//		$arr = array('A', 'B', 'C', 'D', 'E', 'F',
//			'G', 'H', 'I', 'J', 'K', 'L',
//			'M', 'N', 'P', 'R', 'S',
//			'T', 'U', 'V', 'X', 'Y', 'Z',
//			'1', '2', '3', '4', '5', '6',
//			'7', '8', '9', '0');
		$arr = ['1', '2', '3', '4', '5', '6','7', '8', '9', '0'];
		$promo = "";

		if (isset(\Yii::$app->params['CSmsClub']['testMode']) && \Yii::$app->params['CSmsClub']['testMode']){
			// активирован тестовый режим - СМС не отсылаются
			$promo = \Yii::$app->params['CSmsClub']['testMode'];
		} else {
			for ($i = 0; $i < $length; $i++) {
				$index = rand(0, count($arr) - 1);
				$promo .= $arr[$index];
			}
		}
		return $promo;
	}

}