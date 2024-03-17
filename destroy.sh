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

# Check if environment exists 
if [ ! -d "$MAIN_DIRECTORY/$TF_ENVIRONMENTS/$ENVIRONMENT" ]; then
  echo "Environment $ENVIRONMENT does not exist."
  exit 1
fi

CONFIG_TFSTATE_SCRIPT="configTfstateLocation.sh"

# Run bash script to configure .tfstate location
if ! "$MAIN_DIRECTORY/$CONFIG_TFSTATE_SCRIPT" \
  -backend_file_location="$MAIN_DIRECTORY/$TF_DIRECTORY/backend.tf" \
  -tfstate_file_loaction="../$TF_ENVIRONMENTS/$ENVIRONMENT/terraform.tfstate"; then
  exit 1
fi

# Run terraform commands to destroy existing infrastructure
cd $MAIN_DIRECTORY/$TF_DIRECTORY

terraform init -reconfigure
terraform destroy -auto-approve
