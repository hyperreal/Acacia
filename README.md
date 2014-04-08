Acacia
======

Announcements system

## If you want to develop Acacia

 * `git clone https://github.com/hyperreal/Acacia.git`
 * Install [Vagrant][1], [VirtualBox][2] and its Guest Additions
 * Modify your hosts file (`/etc/hosts` on Linux/OSX, `$WINDIR\system32\drivers\etc\hosts` on Windows) and add following line at the end of file:

```
192.168.33.10 acacia.local
```
 
 * Run `vagrant up` inside cloned repository
 * Check http://acacia.local/ in your browser :-) (admin credentials: username: `admin`, password: `acacia123`)
 * If you want to check logs or install additional packages, you can run `vagrant ssh` inside cloned repository.



[1]: http://vagrantup.com/
[2]: https://www.virtualbox.org/