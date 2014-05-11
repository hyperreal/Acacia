Acacia
======

Open classifieds system

## If you want to develop Acacia

 * `git clone https://github.com/hyperreal/Acacia.git`
 * Install [Vagrant][1], [VirtualBox][2] and its Guest Additions
 * Modify your hosts file (`/etc/hosts` on Linux/OSX, `$WINDIR\system32\drivers\etc\hosts` on Windows) and add following line at the end of file:

```
192.168.33.10 acacia.local
```
 
 * Run `vagrant up` inside the cloned repository. Please notice: you must have a good internet connection at this moment, as the vagrant environment buildup process requires downloading a lot of stuff. 
 * Check http://acacia.local/ in your browser :-) (admin credentials: username: `admin`, password: `acacia123`)
 * If you want to check logs or install additional packages, you can run `vagrant ssh` inside cloned repository.

## How to... ?

*Automatically compile less files*

Log in into your vagrant virtual machine via `vagrant ssh` and:

```
cd /var/www/acacia && grunt watch
```

Please be aware it actively and continuously scans directories with less files, creating some virtual machine load. Remember to switch it off when you are not developing for a longer period.



[1]: http://vagrantup.com/
[2]: https://www.virtualbox.org/
