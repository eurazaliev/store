<?php 
$name = "MegaServer-005";
$memo = "Создается acceptence test Codeception";
$memory = 64;
$cpu = 4;
$hdd = 350;
$ipaddr = "172.15.32.34";
$os = "Windows Server 2016";

$I = new AcceptanceTester($scenario);
$I->wantTo('perform actions and see result');

//вначале создаем запись с частично незаполненными полями, должне выбросить исключение
$I->amOnPage('/server');
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
$I->see('Сервер'); 
$I->fillField('Name', $name);
$I->fillField('Memo', $memo);
$I->checkOption('server[is_vm]');
$I->click('Submit');
$I->see('An exception occurred while executing');

//а теперь заполняем все поля, должна добавиться запись
$I->fillField('Name', $name);
$I->fillField('Memo', $memo);
$I->checkOption('server[is_vm]');
$I->fillField('Mem', $memory);
$I->fillField('Cpu', $cpu);
$I->fillField('Hdd', $hdd);
$I->fillField('Ipaddr', $ipaddr);
$I->click('Submit');
$I->see('Done');

//редактируем созданную запись
$I->click('>>');
$I->click($name);
$I->see("Редактирование $name");
$I->fillField('Hdd', 100);
$I->selectOption('server[os_id]', $os);
$I->click('Submit');
$I->see('Error');
$I->amOnPage('/server');
$I->click('>>');


//наконец удаляем
//$I->click("Удалить $name");
//$I->see("Deleted $name");
