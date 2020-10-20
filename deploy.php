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
add('writable_dirs', []);

set('writable_use_sudo', true);

// Hosts

host('139.59.99.5')
	->user('deployer')
	->identityFile('~/.ssh/deployerkey')
	->set('deploy_path', '/var/www/html/api-mangdropship');

// Tasks

task('build', function () {
	run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.

after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');
