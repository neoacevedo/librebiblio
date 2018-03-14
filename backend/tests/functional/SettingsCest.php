<?php
namespace backend\tests;
use backend\tests\FunctionalTester;

class SettingsCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function showSettings(FunctionalTester $I)
    {
        $I->amOnPage('/admin/settings');
        #$I->fillField('Username', 'erau');
        #$I->fillField('Password', 'password_0');
        #$I->click('login-button');

        #$I->see('Logout (erau)', 'form button[type=submit]');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }
}
