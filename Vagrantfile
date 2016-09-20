Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/trusty64"
  config.vm.network "private_network", ip: "192.168.33.33"
  config.vm.hostname = "skyeng"
  config.vm.synced_folder ".", "/vagrant"
  config.vm.provision "shell", path: "vagrant_script.sh"
  config.vm.network "forwarded_port", guest: 8888, host: 8888
  
end
