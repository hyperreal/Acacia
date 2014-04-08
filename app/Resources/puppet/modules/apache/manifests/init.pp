class apache {

  $packages = ['apache2', 'libapache2-mod-php5']

  package { $packages:
    ensure => present
  }

  service { 'apache2':
    ensure => "running",
    require => Package['apache2']
  }

  file { "/etc/apache2/sites-available/acacia":
    ensure => present,
    content => template('apache/vhost/acacia.erb'),
    notify => Service['apache2'],
    require => [ Package['apache2'], Package['libapache2-mod-php5'] ]
  }

  exec { 'enable_acacia':
    command => '/usr/sbin/a2ensite acacia',
    notify => Service['apache2'],
    require => File['/etc/apache2/sites-available/acacia']
  }
}