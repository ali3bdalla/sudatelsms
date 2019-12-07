<?php
	
	namespace Sudatel;
	
	use Symfony\Component\HttpClient\HttpClient;
	use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
	use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
	use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
	use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
	use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
	
	
	/**
	 * Class SMS
	 *
	 * @package Sudatel
	 */
	class SMS extends Helper
	{
		
		private $sender;
		private $password;
		private $username;
		private $headers;
		private $statusCode;
		private $contentType;
		private $content;
		
		/**
		 * SMS constructor.
		 *
		 * @param string $username
		 * @param string $password
		 * @param string $sender
		 */
		public function __construct($username = '',$password = '',$sender = 'sender')
		{
			$this->password = $password;
			$this->username = $username;
			$this->sender = $sender;
		}
		
		/**
		 * @param string $content
		 * @param array $mobiles_numbers
		 *
		 * @return bool
		 * @throws ClientExceptionInterface
		 * @throws DecodingExceptionInterface
		 * @throws RedirectionExceptionInterface
		 * @throws ServerExceptionInterface
		 * @throws TransportExceptionInterface
		 */
		public function send($content = "",$mobiles_numbers = [])
		{
			
			$client = HttpClient::create();
			$response = $client->request('GET',self::SEND_SMS_ROUTE,[
				'query' => [
					'user' => $this->username,
					'Sender' => $this->sender,
					'pwd' => $this->password,
					'smstext' => $content,
					'Nums' => $this->convertArrayToStringWithComma($mobiles_numbers),
				],
			]);

//			var_dump($response->getInfo());
			$this->statusCode = $response->getStatusCode();
			$this->headers = $response->getHeaders();
			$this->content = $response->getContent();
			$this->contentType = $response->getHeaders()['content-type'][0];
			
			if ($this->statusCode == 200)
				return true;
			else
				return false;
			
		}
		
		/**
		 * @return string
		 * @throws ClientExceptionInterface
		 * @throws RedirectionExceptionInterface
		 * @throws ServerExceptionInterface
		 * @throws TransportExceptionInterface
		 */
		public function getBalance()
		{
			$client = HttpClient::create();
			$response = $client->request('GET',self::CHECK_BALANCE_ROUTE,[
				'query' => [
					'user' => $this->username,
					'pwd' => $this->password,
				],
			]);
			
			$this->statusCode = $response->getStatusCode();
			$this->headers = $response->getHeaders();
			$this->content = $response->getContent();
			$this->contentType = $response->getHeaders()['content-type'][0];
			
			return money_format("%i",$this->content);
			
		}
		
		/**
		 * @return mixed
		 */
		public function getContentType()
		{
			return $this->contentType;
		}
		
		/**
		 * @return mixed
		 */
		public function getHeaders()
		{
			return $this->headers;
		}
		
		/**
		 * @return mixed
		 */
		public function getStatusCode()
		{
			return $this->statusCode;
		}
		
		/**
		 * @return mixed
		 */
		public function getContent()
		{
			return $this->content;
		}
		
	}