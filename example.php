<?php
//���������� ��� �����
include 'WalletOne.class.php';

// ID ������ �������� � ������� WalletOne
$Merchant_Id        = 15641354568;

// ��������� ���� ����������� � ���������� WalletOne
$Merchant_SecretKey = 'jkdhksd6521g5s65g4s6d21g654rf6h6sasg56jk54hg';

//������ ������
$WalletOne = new WalletOne($Merchant_Id, $Merchant_SecretKey);

//ID ������� � ����� �������
$payId = 1;

//����� ��� ������
$payAmount = 30;

//�������� ������
if(isset($_GET['pay'])){
    
    //���������� �������� �����
    $WalletOne->Pay($payId,$payAmount);
    
    //������� �������� �����
    print $WalletOne->form();
}

//Result URL
if(isset($_GET['result'])){
    //�������� � ������� ��� ������ ��������� �� WalletOne
    $WalletOne->result();
    
    //���� �� ��� ����� ������ �������, �� ����� ������������ ���� �����
    //���������� ������:
    //[id] - ID ������� � ����� ������� ������� ��� ����� ��� ������
    //[Status] - ������ �������. 1 - �������� �����, 2 - ��������� ������
    //[Signature] - ������� �������
    $callback = $WalletOne->callback();
    
}