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
  #owner => "www-data",
  #group => "www-data",
  #mode => "0775",
  recurse => true,
}

class { 'apache':
  require => [ Exec['apt-update'], Package['php5'] ]
}

class { "::mysql::server":
  root_password => "root",
}

mysql::db { "acacia":
  ensure => present,
  charset => 'utf8',
  collate => 'utf8_polish_ci',
  user => "acacia",
  password => "acacia",
  host => 'localhost',
}

class 