<?php 
$country = "Венгрия";
$country_memo = "Мадьяры";

$I = new AcceptanceTester($scenario);
$I->wantTo('perform actions and see result');

$I->amOnPage('/');
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
$I->see('Main page'); // ! Тут часть фразы с вашей главной
$I->amOnPage('/about');
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
$I->see('Donec imperdiet ante'); // ! Тут часть фразы с вашей страницы about

$I->amOnPage('/country');
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
$I->see('Страна'); // ! Тут часть фразы с вашей страницы about
$I->fillField('Name', $country);
$I->fillField('Memo', $country_memo);
$I->checkOption('country[sactions]');
$I->click('Submit');
$I->see('Done');

$I->click($country);
$I->see("Редактирование $country");
$I->fillField('Memo', 'Румыны');
$I->click('Update');

$I->click("Удалить $country");
$I->see("Deleted $country");


