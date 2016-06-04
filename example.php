<?php
include 'WalletOne.class.php';

$Merchant_Id        = 15641354568;
$Merchant_SecretKey = 'jkdhksd6521g5s65g4s6d21g654rf6h6sasg56jk54hg';

$WalletOne = new WalletOne($Merchant_Id, $Merchant_SecretKey);

$payId = 1;
$payAmount = 30;
if(isset($_GET['pay'])){
    $WalletOne->Pay($payId,$payAmount);
    
    print $WalletOne->form();
}
if(isset($_GET['result'])){
    $WalletOne->result();
    
    $callback = $WalletOne->callback();//CallBack data;
    
}