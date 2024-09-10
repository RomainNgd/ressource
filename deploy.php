<?php
namespace Deployer;

require 'recipe/symfony.php';

// Configuration du projet
set('application', 'ressources');
set('repository', 'git@github.com:RomainNgd/ressource.git');

// Configurer la machine distante
host('production')
    ->setHostname('82.66.110.4')
    ->setPort(2222)
    ->set('remote_user', 'romain')
    ->set('deploy_path', '/var/www/ressource')
    ->set('identity_file', '~/.ssh/id_rsa');

// Configurer Docker
desc('Start Docker containers');
task('docker:up', function () {
    run('cd {{deploy_path}}/current && docker-compose up -d');
});

desc('Stop Docker containers');
task('docker:down', function () {
    run('cd {{deploy_path}}/current && docker-compose down');
});

// Déploiement standard Symfony
task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:publish',
    'docker:up',
]);

// Si un déploiement échoue
after('deploy:failed', 'deploy:unlock');