<?php 
$name = "JP";
$memo = "Япошки";

$I = new AcceptanceTester($scenario);
$I->wantTo('perform actions and see result');

$I->amOnPage('/language');
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
$I->see('Язык'); // ! Тут часть фразы с вашей страницы about
$I->fillField('Name', $name);
$I->fillField('Memo', $memo);
//$I->checkOption('country[sactions]');
$I->click('Submit');
$I->see('Done');


$I->click($name);
$I->see("Редактирование $name");
$I->fillField('Memo', 'Румыны');
$I->click('Редактировать');

$I->click("Удалить $name");
$I->see("Deleted $name");

