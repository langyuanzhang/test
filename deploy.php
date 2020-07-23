<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name 项目名
set('application', 'my_project');

// Project repository 项目仓库地址
set('repository', 'git@github.com:langyuanzhang/test.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys  分享文件即目录，通常也不用改，默认包含了 storage 目录
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server  可写目录，一般不用改
add('writable_dirs', []);

// 保存最近五次部署，这样的话回滚最多也只能回滚到前 5 个版本
set('keep_releases', 5);

// 实践证明，这样能减少一些不必要的麻烦,如出现权限相关的问题，也可将此项设置为 true 后尝试
set('writable_use_sudo', false);


// 生产用的主机
host('49.235.144.147')
    ->stage('production')
    ->user('root')
    ->port(22)
    ->set('branch', 'master') // 最新的主分支部署到生产机
    ->set('deploy_path', '/home')
    ->identityFile('/home/vagrant/.ssh/id_rsa')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->set('http_user', 'www') // 这个与 nginx 里的配置一致
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no');


// Hosts 目标主机配置，这是最基本的
// host('test.test')
//     ->set('deploy_path', '~/{{application}}');    
    
// Tasks
task('test', function () {
    writeln('Hello world');
});

// 这算是个自定义任务示例
// task('build', function () { 
//     run('cd {{release_path}} && build');
// });

// [Optional] if deploy fails automatically unlock. 如果部署失败，自动解除部署锁定状态，以免影响下次执行
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release. 执行数据库迁移，建议删掉，迁移虽好，但毕竟高风险，只推荐用于开发环境。

// before('deploy:symlink', 'artisan:migrate');

