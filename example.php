<?php
//Подключаем наш класс
include 'WalletOne.class.php';

// ID Вашего магазина в системе WalletOne
$Merchant_Id        = 15641354568;

// Секретный ключ прописанный в настройках WalletOne
$Merchant_SecretKey = 'jkdhksd6521g5s65g4s6d21g654rf6h6sasg56jk54hg';

//Создаём объект
$WalletOne = new WalletOne($Merchant_Id, $Merchant_SecretKey);

//ID платежа в вашей системе
$payId = 1;

//Сумма для оплаты
$payAmount = 30;

//Страница оплаты
if(isset($_GET['pay'])){
    
    //Генерируем Платёжную форму
    $WalletOne->Pay($payId,$payAmount);
    
    //Выводит платёжную форму
    print $WalletOne->form();
}

//Result URL
if(isset($_GET['result'])){
    //Получаем и сверяем все данные пришедшие из WalletOne
    $WalletOne->result();
    
    //Если же вам нужны данные платежа, то можно использовать этот метод
    //Возвращает массив:
    //[id] - ID платежа в вашей системе который был задан при оплате
    //[Status] - Статус платежа. 1 - Успешный платёж, 2 - произошла ошибка
    //[Signature] - Подпись платежа
    $callback = $WalletOne->callback();
    
}