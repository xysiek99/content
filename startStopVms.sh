#!/usr/bin/env bash

for arg in "$@"; do
  case $arg in
    -environment=*)
      ENVIRONMENT="${arg#*=}"
      ;;
    -action=*)
      ACTION="${arg#*=}"
      ;;
    *)
      echo "Unknown argument: $arg"
      exit 1
      ;;
  esac
done

# Checking if both arguments are provided
if [ -z "$ENVIRONMENT" ] || [ -z "$ACTION" ]; then
  echo "Missing arguments. Usage: $0 -environment=<environment> -action=<start_or_stop>"
  exit 1
fi

export TF_VAR_infra_environment=$ENVIRONMENT

if [ "$ACTION" = "start" ]; then
  export TF_VAR_is_running=true
elif [ "$ACTION" = "stop" ]; then
  export TF_VAR_is_running=false
else
  echo "Invalid action. Use -action=start or -action=stop"
  exit 1
fi

MAIN_DIRECTORY=$(pwd)
TF_DIRECTORY="setup-terraform"
TF_ENVIRONMENTS="environments-terraform"

CONFIG_TFSTATE_SCRIPT="configTfstateLocation.sh"

# Run bash script to configure .tfstate location
if ! "$MAIN_DIRECTORY/$CONFIG_TFSTATE_SCRIPT" \
  -backend_file_location="$MAIN_DIRECTORY/$TF_DIRECTORY/backend.tf" \
  -tfstate_file_loaction="../$TF_ENVIRONMENTS/$ENVIRONMENT/terraform.tfstate"; then
  exit 1
fi

# Run terraform commands in terraform directory
cd $MAIN_DIRECTORY/$TF_DIRECTORY

terraform init -reconfigure
terraform apply -auto-approve