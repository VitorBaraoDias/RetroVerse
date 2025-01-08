<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class SignupCest
{
    protected $formId = '#login-form';


    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/signup');
    }

    protected function formParams($email, $username, $password)
    {
        return [
            'SignupForm[email]' => $email,
            'SignupForm[username]' => $username,
            'SignupForm[password]' => $password,
        ];
    }
    public function checkInvalidEmail(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('invalidemail', 'newuser', 'password123'));
        $I->seeValidationError('Email is not a valid email address.');
    }

    public function checkValidSignup(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('newuser@example.com', 'newuser', 'password123'));
        $I->seeCurrentUrlEquals("/index-test.php");
        $I->see('Thank you for registration. Please check your inbox for verification email.');

        $I->seeElement('a[href="/index-test.php/site/signup"] img[src="/img/myaccount.svg"]');

        $I->dontSeeLink('Signup');
        $I->dontSeeLink('Login');

    }

    public function signupWithWrongEmail(FunctionalTester $I)
    {
        $I->submitForm(
            $this->formId, [
            'SignupForm[username]'  => 'tester',
            'SignupForm[email]'     => 'ttttt',
            'SignupForm[password]'  => 'tester_password',
        ]
        );
        $I->dontSee('Username cannot be blank.', '.invalid-feedback');
        $I->dontSee('Password cannot be blank.', '.invalid-feedback');
        $I->see('Email is not a valid email address.', '.invalid-feedback');
    }

}
