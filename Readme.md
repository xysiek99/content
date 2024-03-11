# Things needed:
- Linode account (https://www.linode.com/)
- Linode account token configured to READ&WRITE Linode instances (called "Linodes")
- Machine with Terraform and Ansible installed
- SSH Key pair for user on VMs, it can be created by script ```checkSshKeys.sh``` (it is part of ```deploy.sh``` script, so there is no need to run it manually)
- Add your linode token to environment variables as well as root password for initial setup - name it ```TF_VAR_linode_token``` and ```TF_VAR_root_password``` - it can be added into your .profile or .bashrc file, exported in shell before running deployment or exported directly in files ```deploy.sh``` and ```destroy.sh```. Also one of the helper scripts triggered by ```deploy.sh``` will eventually inform you about missing variables
- Ansible vault password file and file with secrets dedicated for one of the roles - if they are missing they will be created automatically by one of the helper scripts triggered by ```deploy.sh```

# Content of folders:
- php_application: php application content
- setup-ansible: ansible scripts to setup VMs - run basic security steps, configure VMs (one as local docker registry, another hosting containerized php application) and start contenerized app
- setup-terraform: terraform scripts to create 2 VMs on Linode, create user on VMs and configure ```~/.ssh/config``` file on local machine 

# Access application:
To access deployed php application got browser and enter link "http://<php_app_vm_ip>:80"
IP of php_app_vm can be checked in ```~/.ssh/config``` file in which you will see entry looking like below:
```
Host php_vm
  HostName 143.42.54.229
  User inzynier
  IdentityFile ~/.ssh/inzynier_key
```
# Deployment infrastructure and application:
### Deployment:
- run script ```deploy.sh``` - it will do all steps from setting up infrastructure via terraform and doing all configuration and deployment via ansible. It also uses helper scripts to check for Environment variables, SSH Keys and Ansible secrets
### Destroy:
- run script ```destroy.sh``` - it will destroy all cloud infrastructure
