exec { "apt-update":
  command => "/usr/bin/apt-get update",
}

$dependencies = [
  "php5",
  "php5-cli",
  "php5-apc",
  "php5-curl",
  "php5-mysql",
  "php5-intl",
  "php5-mcrypt",
  "git",
  "vim",
  "htop",
  "sendmail"
]

package { $dependencies:
  ensure => present,
  require => Exec['apt-update']
}

file { "/var/www/acacia":
  ensure => "directory",
  #owner => "www-data",
  #group => "www-data",
  #mode => "0775",
  recurse => true,
}

class { "apache": }
class { "apache:mod:php": }
apache::vhost { "acacia":
  priority => 000,
  port => 80,
  docroot => "/var/www/acacia/web",
  ssl => false,
  servername => "app.local",
  options => ["FollowSymlinks MultiViews"],
  override => ["All"],
  ensure => present,
  require => File['/var/www/acacia']
}

class { "mysql": }
class { "mysql:php": }
class { "mysql:server":
  config_hash => {
    "root_password" => "root"
  }
}

mysql::db { "acacia":
  user => "acacia",
  password => "acacia",
  host => 'localhost',
  grant => ['all'],
  require => Class['mysql:server'],
}

