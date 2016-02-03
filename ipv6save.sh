#!/bin/bash
# Скрипт для сохранения IP адреса 
# в базе проекта www.grio.ru/ipv6/
# ver.1.1
# Для корректной работы скрипта
# miredo и curl должен быть установлен.

email="vasia@pupkin.ru"; #E-mail, зарегистрированный на сайте grio.ru/ipv6/
password="parol"; #Пароль
computer="Moy_Laptop"; #Имя компьютера
interval=5; #Проверять акутальность IP каждые N минут
ifconfig="/sbin/ifconfig"; #Путь до ifconfig
curl="/usr/bin/curl"; #Путь до curl

interval=$(($interval*60));

while (true);
do

# Узнаем свой IPv6
ipv6=$($ifconfig teredo | grep /32 | awk '{print $3}' | sed 's/\/32//');

if [[ "$ipv6" != "$oldip" ]]
then

# Сохраняем его в базе проекта
servermsg=$($curl "http://grio.ru/ipv6/save.php?email=$email&name=$computer&pass=$password&ip=$ipv6" 2>/dev/null);

# Широковещательная передача при смене IP 
# echo "$ipv6 - $servermsg ex: $oldip" | wall;

fi

oldip="$ipv6";
sleep $interval;

done

# Для того, что бы извлечь IP из базы, можно воспользоваться командой:
# curl http://grio.ru/ipv6/load.php?email=vasia@pupkin.ru&name=Moy_Laptop&pass=parol