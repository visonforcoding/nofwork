<?php

$refund_nos = [1,2,3,4];
$chs = [];
foreach($refund_nos as $refund_no){
    $chs[] = curl_init();
}