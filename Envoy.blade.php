@servers(['aws' => 'ubuntu@52.89.132.202'])

@include('vendor/autoload.php')

@setup
    $origin = 'https://github.com/vendty/api_tienda';
    $folder = '/var/www/tienda';
    $branch = 'master';
@endsetup

@task('deploy', ['on' => 'aws'])
    cd {{ $folder }}
    sudo git pull origin {{ $branch }}
    sudo composer install --optimize-autoloader --no-dev
@endtask
