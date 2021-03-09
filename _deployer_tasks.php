<?php

namespace Deployer;

desc('GeoIP Database Update.');
task('artisan:geoip:update', function() {
    run('php {{release_path}}/artisan geoip:update');
});

desc('Clear Horizon failed jobs.');
task('artisan:horizon:flush', function() {
    run('php {{release_path}}/artisan queue:flush');
});

desc('Clear all logs in storage.');
task('logs:clear', function() {
    run('rm -rf {{release_path}}/storage/logs/*.log');
});

desc('Clear cached views.');
task('views:clear', function() {
    run('rm -rf {{release_path}}/storage/framework/views/*');
});
