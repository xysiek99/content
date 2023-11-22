#!/usr/bin/env bash

MAIN_DIRECTORY=$(pwd)
TF_DIRECTORY="setup-terraform"
ANSIBLE_DIRECTORY="setup-ansible"

# Run terraform commands in terraform directory
cd $MAIN_DIRECTORY/$TF_DIRECTORY

terraform init
terraform apply -auto-approve

# Run ansible commands in ansoble directory
cd $MAIN_DIRECTORY/$ANSIBLE_DIRECTORY

export ANSIBLE_HOST_KEY_CHECKING=False

ansible-playbook playbooks/initial-setup.yml -i inventory/DEV
ansible-playbook playbooks/docker-setup.yml -i inventory/DEV
ansible-playbook playbooks/docker-registry-setup.yml -i inventory/DEV 
ansible-playbook playbooks/deploy-php-app-container.yml --vault-password-file vault_password.txt -i inventory/DEV