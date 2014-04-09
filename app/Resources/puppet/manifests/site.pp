

define acacia_db {
  class { "::mysql::server":
    root_password => "root",
  }

  mysql::db { "acacia":
    ensure => present,
    charset => 'utf8',
    collate => 'utf8_polish_ci',
    user => "acacia",
    password => "acacia",
    host => 'localhost'
  }  
}


define symfony_command ($command, $onlyif = undef, $require = undef) {
  exec { $name:
    command => "php /var/www/acacia/app/console ${command}",
    path => '/bin:/usr/bin:/usr/local/bin:/usr/sbin:/usr/local/node/node-default',
    cwd => '/var/www/acacia',
    onlyif => $onlyif,
    require => $require,
  }
}

define js_deps ($use_path) {
  class { 'nodejs':
    version => 'v0.10.26',
    make_install => false
  }

  file_line { 'ci_env': 
  	path => '/etc/environment',
  	line => 'CI=true'
  }

  package { ['grunt-cli', 'bower']:
    provider => 'npm',
    ensure => present,
    require => Class['nodejs'],
  }

  exec { 'install_npm_deps':
    command => 'npm install',
    path => $use_path,
    cwd => '/var/www/acacia',
    require => Class['nodejs'],
    creates => '/var/www/acacia/node_modules/grunt/package.json'
  }

  exec { 'install_bower_deps':
    command => 'bower install -f -q --allow-root',
    environment => ["CI=true"], # dont ask for sending anon stats
    path => $use_path,
    cwd => '/var/www/acacia',
    require => Package['bower'],
    creates => '/var/www/acacia/web/components/bootstrap/package.json'
  }
}

##########################################################################################################

$acacia_path = '/bin:/usr/bin:/usr/local/bin:/usr/sbin:/usr/local/node/node-default/bin'

exec { "apt-update":
  command => "/usr/bin/apt-get update",
}

$dependencies = [
  "php5",
  "php5-cli",
  "php-apc",
  "php5-curl",
  "php5-sqlite",
  "php5-mysql",
  "php5-intl",
  "php5-mcrypt",
  "git",
  "vim",
  "curl",
  "htop",
]

package { $dependencies:
  ensure => present,
  require => Exec['apt-update']
}

file_line { 'acacia_local_host':
  path => '/etc/hosts',
  line => '127.0.0.1  acacia.local'
}

file { "/var/www/acacia":
  ensure => "directory",
  recurse => true,
}

class { 'apache':
  require => [ Exec['apt-update'], Package['php5'] ]
}

acacia_db { 'acacia_db': }

exec { 'create_parameters_yml':
  command => 'cp /var/www/acacia/app/config/parameters.yml.dist /var/www/acacia/app/config/parameters.yml',
  path => $acacia_path,
  onlyif => 'test ! -f /var/www/acacia/app/config/parameters.yml'
}

exec { 'install_composer':
  command => 'curl -Ss https://getcomposer.org/installer | php',
  path => $acacia_path,
  cwd => '/usr/local/bin',
  require => [ Package['curl'], Package['php5-cli'] ],
  onlyif => 'test ! -f /usr/local/bin/composer.phar'
}

exec { 'install_symfony_vendors':
  command => 'composer.phar install --prefer-dist',
  cwd => '/var/www/acacia',
  path => $acacia_path,
  require => Exec['install_composer'],
  onlyif => 'test ! -f /var/www/acacia/vendor/autoload.php'
} ->

js_deps { 'js_deps': 
  use_path => $acacia_path
} ->

symfony_command { 'assets_install': 
  command => 'assets:install --symlink --relative /var/www/acacia/web',
  require => [ Js_deps['js_deps'], Exec['install_symfony_vendors'] ]
} ->

exec { 'run_chown':
  command => 'chown -R vagrant:www-data /var/www/acacia',
  path => $acacia_path
}

symfony_command { 'create_db':
  command => 'doctrine:schema:create',
  require => [ Exec['install_symfony_vendors'], Acacia_db['acacia_db'] ],
  onlyif => 'test ! -f /var/lib/mysql/acacia/users.frm'
}

symfony_command { 'install_admin_user':
  command => 'fos:user:create admin admin@acacia.local acacia123',
  require => Symfony_command['create_db'],
  onlyif => "/usr/bin/mysql -u acacia -pacacia -e 'SELECT COUNT(*) FROM users' acacia | tail -n 1 | grep '^0$'"
}
