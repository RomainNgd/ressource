<?php
namespace Deployer;

require 'recipe/symfony.php';

set('application', 'ressource');
set('repository', 'git@github.com:RomainNgd/ressource.git');

host('production')
->setHostname('82.66.110.4')
->setPort(2222)
->set('remote_user', 'romain')
->set('identity_file', '~/.ssh/id_rsa')
->set('forward_agent', true)  // Utiliser l'agent SSH
->set('deploy_path', '/var/www/ressource');

task('deploy', [
'deploy:prepare',
'deploy:vendors',
'deploy:clear_paths',
'deploy:publish',
]);

after('deploy:failed', 'deploy:unlock');
