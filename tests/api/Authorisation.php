<?php

class Authorisation
{
    //class with Transporters token for testing
    public static function setAuthorisationToken(ApiTester $I) {
        $cookie = new Symfony\Component\BrowserKit\Cookie('auth_token', 'd8af1f1d29016d1c4b13954d6a605a62b511c88f8f35539a3efd97547e925132');
        $I->getClient()->getCookieJar()->set($cookie);
    }

}