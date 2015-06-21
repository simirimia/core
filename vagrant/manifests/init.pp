package {
  [
    "joe",
    "curl",
    "git",
    "php5",
    "php5-cli",
    "php5-xdebug",
    "screen",
    "sed"
  ]:
    ensure => present
}

# composer
exec { 'composer-install-self':
  command      => '/usr/bin/curl -sS https://getcomposer.org/installer | /usr/bin/php -- --install-dir=/usr/local/bin --filename=composer',
  require => Package["php5-cli","curl"],
  creates => '/usr/local/bin/composer'
}
exec { 'composer-install-packages':
  command => "/usr/local/bin/composer install",
  cwd => "/vagrant",
  user => "vagrant",
  environment => [ "COMPOSER_HOME=/usr/local/bin" ],
  require => [ Exec["composer-install-self"],
    Package["git"]
  ]
}

# PHP
file { '/etc/php5/mods-available/xdebug.ini':
  ensure => 'file',
  content => '
[XDEBUG]
zend_extension=xdebug.so
xdebug.remote_port=9000
xdebug.default_enable=1
xdebug.remote_connect_back=1
xdebug.remote_enable=1
xdebug.remote_handler=dbgp
xdebug.remote_port=9000
xdebug.remote_autostart=1
        '
}
