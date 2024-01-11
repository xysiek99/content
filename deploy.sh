#!/usr/bin/env bash

MAIN_DIRECTORY=$(pwd)
TF_DIRECTORY="setup-terraform"
ANSIBLE_DIRECTORY="setup-ansible"

CHECK_ENV_VARS_SCRIPT="checkEnvVars.sh"
CHECK_SSH_KEYS_SCRIPT="checkSshKeys.sh"
CHECK_ANSIBLE_SECRETS_SCRIPT="checkAnsibleSecrets.sh"

ANSIBLE_VAULT_PWD_FILE="vault_password.txt"
ANSIBLE_PHP_IMG_DEPLOY_SECRETS_FILE="roles/deploy-php-application/defaults/secrets.yml"

# Run bash script to check required environment variables 
if ! "$MAIN_DIRECTORY/$CHECK_ENV_VARS_SCRIPT"; then
  exit 1
fi

# Run bash script to check if key pair exist, eventually recreate it
if ! "$MAIN_DIRECTORY/$CHECK_SSH_KEYS_SCRIPT"; then
  exit 1
fi

# Run terraform commands in terraform directory
cd $MAIN_DIRECTORY/$TF_DIRECTORY

terraform init
terraform apply -auto-approve

# Run ansible commands in ansible directory
cd $MAIN_DIRECTORY/$ANSIBLE_DIRECTORY

export ANSIBLE_HOST_KEY_CHECKING=False

ansible-playbook playbooks/initial-setup.yml -i inventory/DEV
ansible-playbook playbooks/docker-setup.yml -i inventory/DEV
ansible-playbook playbooks/docker-registry-setup.yml -i inventory/DEV 
ansible-playbook playbooks/deploy-php-app-container.yml --vault-password-file vault_password.txt -i inventory/DEV
