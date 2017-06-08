<?php
namespace Deployer;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

//argument('stage', InputArgument::REQUIRED, 'stage.');

require 'recipe/laravel.php';
// require 'recipe/common.php';

// Configuration

//set('git_tty', true); // [Optional] Allocate tty for git on first deployment

option('mystage', null, InputOption::VALUE_REQUIRED, 'My Stage');

// cheat and get mystage
$mystage = null;
global $argv;
foreach($argv as $arg){
	if(!preg_match('/^--mystage=/', $arg)) continue;
	$args = explode('=', $arg);
	if(!empty($args[1])) $mystage = $args[1];
}

if(!$mystage){
	die('no mystage');;
}

inventory('deployer/hosts/'.$mystage.'.yml');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

//before('deploy', 'include:stage');
// Migrate database before symlink new release.

//before('deploy:symlink', 'artisan:migrate');
