<?php
class WalletOne
{
	private $FormParams = array();
	private $__callback = array();
        private $__Merchant_Id;
        private $__Merchant_SecretKey;
        public function __construct($merchant_id, $secret_key)
        {
            $this->__Merchant_Id = $merchant_id;
            $this->__Merchant_SecretKey = $secret_key;
        }
	public function Pay($payId,$amount)
	{
		global $conf;
		$this->SetParam('WMI_MERCHANT_ID',$this->__Merchant_Id);
		$this->SetParam('WMI_PAYMENT_AMOUNT',$amount);
		$this->SetParam('WMI_CURRENCY_ID',643);
		$this->SetParam('WMI_PAYMENT_NO',$payId);
		$this->SetParam('WMI_DESCRIPTION','BASE64:'.base64_encode('YOU DESCRIPTION'));
		$this->SetParam('WMI_SUCCESS_URL','http://'.$_SERVER['HTTP_HOST']);
		$this->SetParam('WMI_FAIL_URL','http://'.$_SERVER['HTTP_HOST']);
		$this->SetParam('WMI_AutoLocation',0);
		$this->sortParams();
		$Signature = $this->GenerateSignature();
		$this->SetParam('WMI_SIGNATURE',$Signature);
	}
	
	private function SetParam($name,$value)
	{
		$this->FormParams[$name] = $value;
	}
	
	private function sortParams()
	{
		uksort($this->FormParams, "strcasecmp");
	}
	private function GenerateSignature()
	{
		global $conf;
                $Signature = implode($this->FormParams);
		$Signature = $Signature.$this->__Merchant_SecretKey;
		$Signature = md5($Signature);
		$Signature = pack("H*",$Signature);
		$Signature = base64_encode($Signature);
		return $Signature;
	}
	
	public function form()
	{
		$form = '<body>
			<form action="https://wl.walletone.com/checkout/checkout/Index" method="POST">';
			
			foreach($this->FormParams as $key => $val){
				$form .= '<input type="hidden" name="'.$key.'" value="'.$val.'">';
			}
			
			$form .= '
				<script>document.getElementsByTagName("form")[0].submit();</script>
			</form>
		</body>';
		return $form;
	}
	
	public function result()
	{
		foreach($_POST as $name => $value){
			if($name !== "WMI_SIGNATURE") $this->SetParam($name,$value);
		}
		$this->sortParams();
		$Signature = $this->GenerateSignature();
                if($Signature == $_POST["WMI_SIGNATURE"]){
                    if($this->FormParams["WMI_ORDER_STATE"] == 'Accepted'){
			$this->__callback["Status"] = 1;
			$this->__callback["text"] = 'WMI_RESULT=OK';
                    }else{
                            $this->__callback["Status"] = 2;
                    }
                }else{
                    $this->__callback["Status"] = 2;
                }
		
	}
	
	public function callback()
	{
		$this->__callback["id"] = $this->FormParams["WMI_PAYMENT_NO"];
		$this->__callback["Signature"] = $this->GenerateSignature();
		return $this->__callback;
	}
}