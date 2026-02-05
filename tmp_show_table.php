<?php
$c = new mysqli('localhost','root','','velvet_vogue');
if($c->connect_error){ echo "CONN_ERR:".$c->connect_error; exit(1); }
$res = $c->query("SHOW TABLES LIKE 'order_items'");
if(!$res || $res->num_rows == 0){ echo "NO_TABLE\n"; exit(0); }
$row = $res->fetch_row();
$t = $row[0];
$r2 = $c->query("SHOW CREATE TABLE `$t`");
$rr = $r2->fetch_assoc();
echo $rr['Create Table'];
