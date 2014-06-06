<?php

namespace Babab\Paulos\Auth;

/**
 * \class CookieAuth
 * \brief Authenticate a user with a persistent login token cookie
 */
class CookieAuth
{
    protected $Db;

    public function __construct(\Babab\Paulos\DB\MySQLHandler $db)
    {
        $this->Db = $db;
        /* echo "CookieAuth<br />\n"; */
    }

    public function test()
    {
        /* echo "CookieAuth::test<br />\n"; */
    }
}
