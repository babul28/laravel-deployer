<?php

namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'laravel-deployer');

// Project repository
set('repository', 'https://github.com/babul28/laravel-deployer.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', ['vendor']);

set('writable_use_sudo', false);

// Set up a deployer task to copy secrets from directory env to /var/www/nama-laravel-project in server.
task('deploy:secrets', function () {
	run('cp $HOME/env/production/.env {{deploy_path}}/shared');
})->desc('Upload DotENV');

// Hosts

host('139.59.99.5')
	->user('deployer')
	->identityFile('~/.ssh/deployerkey')
	->set('deploy_path', '/var/www/html/api-mangdropship')
	->set('http-user', 'www-data');

// Tasks

task('build', function () {
	run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.

after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');
