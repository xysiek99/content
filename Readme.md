# Things needed:
- Linode account (https://www.linode.com/)
- Linode account token (configured to create and destroy resources)
- Machine with Terraform and Ansible installed
- SSH Key pair for user on VMs, can be created using command 'ssh-keygen -b 4096 -t rsa -f ~/.ssh/inzynier_key -q -N ""' (you can name it differently, but remember to change variables in setup-terraform/variables.tf)
- Add your linode token to environment variables - name it 'TF_VAR_linode_token' - it can be added into your .profile file, exported in shell before running deployment or added in files 'deploy.sh' and 'destroy.sh'

# Content of folders:
- php_application: php application content
- setup-ansible: ansible scripts to setup VMs - run basic security steps, configure VMs (one as local docker registry, another hosting containerized php application) and start contenerized app
- setup-terraform: terraform scripts to create 2 VMs on Linode, create user on VMs and configure ~/.ssh/config file on local machine 

# Access application:
To access deployed php application got browser and enter link "http://<php_app_vm_ip>:80"
IP of php_app_vm can be checked in ~/.ssh/config file in which you will see entry looking like below:

Host php_vm
  HostName 143.42.54.229
  User inzynier
  IdentityFile ~/.ssh/inzynier_key

# Deployment infrastructure and application:
### Deployment:
- run script 'deploy.sh' - it will do all steps from setting up infrastructure via terraform and doing all configuration and deployment via ansible
### Destroy:
- run script 'destroy.sh' - it will destroy all cloud infrastructure
