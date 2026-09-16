<?php

$mat_khau = "123456789";

$mat_khau_ma_hoa = password_hash($mat_khau, PASSWORD_DEFAULT);

echo $mat_khau_ma_hoa;

?>