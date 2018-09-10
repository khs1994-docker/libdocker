<?php

/**
*  @link https://github.com/FriendsOfPHP/Sami
*
*  $ sudo curl -fsSL http://get.sensiolabs.org/sami.phar -o /usr/local/bin/sami
*  $ sudo chmod +x /usr/local/bin/sami
*
*  $ sami update .sami.php
*  $ cd build ; php -S 0.0.0.0:8080
*
*/

use Sami\Sami;
use Sami\RemoteRepository\GitHubRemoteRepository;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('public')
    ->exclude('tests')
    ->exclude('example')
    ->exclude('config')
    ->exclude('vendor')
    ->in(__DIR__)
;

return new Sami($iterator);
