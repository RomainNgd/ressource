<?php
namespace Deployer;

require 'recipe/symfony.php';

set('application', 'ressources');
set('repository', 'git@github.com:RomainNgd/ressource.git');

host('production')
    ->setHostname('82.66.110.4')
    ->setPort(2222)
    ->set('remote_user', 'romain')
    ->set('identity_file', '~/.ssh/id_rsa') // À ajuster si besoin
    ->set('forward_agent', true)
    ->set('deploy_path', '/var/www/ressource');

task('deploy', [
    'deploy:prepare',      // Prépare la structure du déploiement
    'deploy:vendors',      // Installe les dépendances Composer
    'deploy:cache:clear',  // Vide le cache Symfony
    'deploy:symlink',      // Met à jour le lien symbolique pour la nouvelle release
    'deploy:unlock',       // Déverrouille le déploiement en cas d'erreur
]);

after('deploy:failed', 'deploy:unlock');