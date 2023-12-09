#!/usr/bin/env bash

MAIN_DIRECTORY=$(pwd)
TF_DIRECTORY="setup-terraform"

# Run terraform commands to destroy existing infrastructure
cd $MAIN_DIRECTORY/$TF_DIRECTORY

terraform destroy -auto-approve
