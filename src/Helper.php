<?php
	
	
	namespace Sudatel;
	
	
	class Helper
	{
		const  SEND_SMS_ROUTE = "http://196.202.134.90/SMSbulk/webacc.aspx";
		const  CHECK_BALANCE_ROUTE = "http://196.202.134.90/SMSbulk/webbal.aspx";
		
		/**
		 * @param array $array
		 */
		protected function convertArrayToStringWithComma($array = [])
		{
			$string = $str = implode(";",$array);
			
			return $string;
		}
	}