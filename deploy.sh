#!/usr/bin/env bash

while [[ $# -gt 0 ]]; do
  key="$1"

  case $key in
    -environment=*)
      ENVIRONMENT="${key#*=}"
      shift
      ;;
    *)
      echo "Unknown option: $1"
      exit 1
      ;;
  esac
done

if [ -z "$ENVIRONMENT" ]; then
  echo "Missing environment argument. Usage: $0 -environment=<env_name>"
  exit 1
fi

export TF_VAR_infra_environment=$ENVIRONMENT

MAIN_DIRECTORY=$(pwd)
TF_DIRECTORY="setup-terraform"
TF_ENVIRONMENTS="environments-terraform"
ANSIBLE_DIRECTORY="setup-ansible"

ANSIBLE_ENVIRONMENT_DIRECTORY="$MAIN_DIRECTORY/$ANSIBLE_DIRECTORY/inventory/$ENVIRONMENT"
TF_ENVIRONMENT_DIRECTORY="$MAIN_DIRECTORY/$TF_ENVIRONMENTS/$ENVIRONMENT"

CHECK_ENV_VARS_SCRIPT="checkEnvVars.sh"
CHECK_SSH_KEYS_SCRIPT="checkSshKeys.sh"
CHECK_ANSIBLE_SECRETS_SCRIPT="checkAnsibleSecrets.sh"
CONFIG_TFSTATE_SCRIPT="configTfstateLocation.sh"

ANSIBLE_VAULT_PWD_FILE="vault_password.txt"
ANSIBLE_PHP_IMG_DEPLOY_SECRETS_FILE="roles/deploy-php-application/defaults/secrets.yml"

# Setup ansible inventory directory and terraform directory for environment's .tfstate file
if [ ! -d "$ANSIBLE_ENVIRONMENT_DIRECTORY" ]; then
  mkdir -p "$ANSIBLE_ENVIRONMENT_DIRECTORY/group_vars"
fi

if [ ! -d "$TF_ENVIRONMENT_DIRECTORY" ]; then
  mkdir -p "$TF_ENVIRONMENT_DIRECTORY"
fi

# Run bash script to configure .tfstate location
if ! "$MAIN_DIRECTORY/$CONFIG_TFSTATE_SCRIPT" \
  -backend_file_location="$MAIN_DIRECTORY/$TF_DIRECTORY/backend.tf" \
  -tfstate_file_loaction="../$TF_ENVIRONMENTS/$ENVIRONMENT/terraform.tfstate"; then
  exit 1
fi

# Run bash script to check required environment variables 
if ! "$MAIN_DIRECTORY/$CHECK_ENV_VARS_SCRIPT"; then
  exit 1
fi

# Run bash script to check if key pair exist, eventually recreate it
if ! "$MAIN_DIRECTORY/$CHECK_SSH_KEYS_SCRIPT"; then
  exit 1
fi

# Run bash script to check for Ansible secrets and vault password file
if ! "$MAIN_DIRECTORY/$CHECK_ANSIBLE_SECRETS_SCRIPT" \
  -vault_pwd_file="$MAIN_DIRECTORY/$ANSIBLE_DIRECTORY/$ANSIBLE_VAULT_PWD_FILE" \
  -secrets_file="$MAIN_DIRECTORY/$ANSIBLE_DIRECTORY/$ANSIBLE_PHP_IMG_DEPLOY_SECRETS_FILE"; then
  exit 1
fi

# Run terraform commands in terraform directory
cd $MAIN_DIRECTORY/$TF_DIRECTORY

terraform init -reconfigure
terraform apply -auto-approve

# Run ansible commands in ansible directory
cd $MAIN_DIRECTORY/$ANSIBLE_DIRECTORY

export ANSIBLE_HOST_KEY_CHECKING=False

ansible-playbook playbooks/initial-setup.yml -i inventory/$ENVIRONMENT
ansible-playbook playbooks/docker-setup.yml -i inventory/$ENVIRONMENT
ansible-playbook playbooks/docker-registry-setup.yml -i inventory/$ENVIRONMENT
ansible-playbook playbooks/deploy-php-app-container.yml --vault-password-file $ANSIBLE_VAULT_PWD_FILE -i inventory/$ENVIRONMENT
