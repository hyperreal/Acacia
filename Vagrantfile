# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = '2'

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box_url = 'http://files.vagrantup.com/precise64.box'
  config.vm.box = 'precise64'
  config.vm.network 'forwarded_port', guest: 80, host: 8080
  config.vm.network :private_network, ip: '192.168.33.10'

  config.vm.synced_folder '.', '/var/www/acacia', id: "vagrant-root", type: "nfs"
  # uncomment if you don't use NFS above
  #     owner: "vagrant",
  #     group: "www-data",
  #     mount_options: ["dmode=775,fmode=664"]


  config.vm.provider :virtualbox do |vb|
    vb.customize ['modifyvm', :id, '--memory', '1024']
  end

  config.vm.provision :puppet do |puppet|
    puppet.options        = '--verbose --debug'
    puppet.manifests_path = 'app/Resources/puppet/manifests'
    puppet.manifest_file  = 'site.pp'
    puppet.module_path    = 'app/Resources/puppet/modules'
  end

end
