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

# Configuration for .tfstate location
cat > "$MAIN_DIRECTORY/$TF_DIRECTORY/backend.tf" <<EOF
terraform {
  backend "local" {
    path = "../$TF_ENVIRONMENTS/$ENVIRONMENT/terraform.tfstate"
  }
}
EOF

# Run terraform commands to destroy existing infrastructure
cd $MAIN_DIRECTORY/$TF_DIRECTORY

terraform init -reconfigure
terraform destroy -auto-approve
