<div class="right_col">
<h2>Что это и как это работает?</h2>
Предположим, у вас есть 2 компьютера, подключенных к интернету. И вы хотите наладить связь между ними.
Например получить доступ к <a href="http://ru.wikipedia.org/wiki/Ssh" target=_blank>SSH</a> или <a href="http://ru.wikipedia.org/wiki/Vnc" target=_blank>VNC</a>.
Задача достаточно простая, если оба компьютера расположены в одной подсети или же просто имеют прямой IP адрес.
А что делать, если оба компьютера находятся за <a href="http://ru.wikipedia.org/wiki/NAT" target=_blank>NAT</a>? 
<br><br>
В этом случае к нам на помощь приходит <a href="http://ru.wikipedia.org/wiki/Ipv6" target=_blank>IPv6</a>. 
Если вы по какой то причине не можете или не хоте получить статический <a href="http://ru.wikipedia.org/wiki/Ipv6" target=_blank>IPv6</a> адрес,
можно воспользоваться сетевым протоколом <a href="http://ru.wikipedia.org/wiki/Teredo" target=_blank>Teredo</a> 
и получить белые <a href="http://ru.wikipedia.org/wiki/Ipv6" target=_blank>IPv6</a> для обоих компьютеров. 
Теперь прямое соединение становится возможным (<i>Для пользователей Windows Seven и Vista, автоматическое получение IPv6 уже заложено в систему</i>). Однако, остается последняя проблема, 
которую призван решить этот проект - динамические <a href="http://ru.wikipedia.org/wiki/Ipv6" target=_blank>IPv6</a> адреса. 
Каждый раз при загрузке компьютера или переподключении к сети наш <a href="http://ru.wikipedia.org/wiki/Ipv6" target=_blank>IPv6</a> будет меняться.
Что бы вы могли в любой момент узнать актуальный адрес нужного компьютера, достаточно сохранить запись о нем на этом сервере. 
Для этого надо всего лишь открыть страницу нашего проекта с актуальными параметрами, например так:
<br><br>
<i>$curl&nbsp;http://www.grio.ru/ipv6/save.php?email=vasia@pupkin.ru&name=Moy_Laptop&pass=parol&ip=fe80::ffff:ffff:ffff</i>
<br><br>
Теперь ваш новый айпи будет сохранен в базе проекта и доступен через поиск или скрипт <a href="load.php" target=_blank><b>load.php</b></a>.
Можно автоматизировать процесс сохранения IPv6 адреса, добавив задание в <a href="http://ru.wikipedia.org/wiki/Cron" target=_blank>СRON</a> или приурочив к загрузке системы.
В ОС <a href="http://ru.wikipedia.org/wiki/Linux" target=_blank>Линукс</a> я использую вот <a href="https://gitorious.org/my-ipv6/my-ipv6/blobs/master/ipv6save.sh" target=_blank>такой скрипт</a>.
<h2>А можно объяснить тоже самое, но по-русски?</h2>
<a href="http://www.grio.ru/ipv6/punbb/viewtopic.php?id=1">Можно.</a>
<br><br>
</div><!-- right_col -->
