#!/usr/bin/env bash

missing_vars=()

if [ -z "$TF_VAR_root_password" ]; then
  missing_vars+=("TF_VAR_root_password")
fi

if [ -z "$TF_VAR_linode_token" ]; then
  missing_vars+=("TF_VAR_linode_token")
fi

if [ ${#missing_vars[@]} -eq 0 ]; then
  exit 0
else
  echo "Environment variables missing:"
  for var in "${missing_vars[@]}"; do
    echo "- $var"
  done
  exit 1
fi
