<?php
$result1 = @mysql_query("create table banners(name varchar(100) NOT NULL UNIQUE,image text,url varchar(200),adtype varchar(10),campaign varchar(200))",$link);
$result2 = @mysql_query("create table campaigns(name varchar(100) NOT NULL UNIQUE,width int, height int,tpye varchar(20),speed int,adtype varchar(10) NOT NULL)",$link);
$result3 = @mysql_query("create table stats(bname varchar(100), date date, time time,ip varchar(30))",$link);
?>
