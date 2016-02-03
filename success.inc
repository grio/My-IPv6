<div class="right_col">
<h2>Поздравляем!</h2>
Ваш компьютер <b><?php echo $_REQUEST["computer"];?></b> добавлен в базу проекта.<br>
Для того, что бы обновить IP вашего компьютера в базе, теперь достаточно открыть страницу <b>save.php</b> с параметрами:<br><br>
<b>email=</b><?php echo $_REQUEST["email"];?><br>
<b>pass=</b><?php echo $_REQUEST["pass"];?><br>
<b>name=</b><?php echo $_REQUEST["computer"];?><br>
<b>ip=</b>ваш::ip:v:6<br>
<br>
Полностью адрес запроса будет выглядеть таким образом:
<br><br>
<i><?php echo "http://grio.ru/ipv6/save.php?email=".$_REQUEST["email"]."&name=".$_REQUEST["computer"]."&pass=".$_REQUEST["pass"]."&ip=...";?></i>
<br><br>
Затем, когда вам потребуется узнать IP адрес вашего компьютера, достаточно будет воспользоваться строкой поиска на сайте проекта или же сформировать свой запрос для страницы <b>load.php</b>:
<br><br>
<i><?php echo "http://grio.ru/ipv6/load.php?email=".$_REQUEST["email"]."&name=".$_REQUEST["computer"]."&pass=".$_REQUEST["pass"];?></i>
<br><br>
Подробнее о настройке IPv6 и прикладных программ можно почитать или спросить на нашем <a href="/punbb/">форуме</a>.
<br><br>
</div><!-- right_col -->