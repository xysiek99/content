#!/usr/bin/env bash

# Checking number of given arguments
if [ $# -ne 2 ]; then
  echo "Missing arguments"
  exit 1
fi

# Mapping arguments to variables
vault_pwd_file="$1"
secrets_file="$2"

# If both of files are present, script will quit
if [ -f "$vault_pwd_file" ] && [ -f "$secrets_file" ]; then
  echo "Secret file and vault password file found"
  exit 0
fi

# If only one of files is present, script will ask to clean it and recreate both with giving passwords or to abort 
read -p "One or more files are missing. Do you want to create vault password file and secrets file? (Y/N): " confirm
if [[ "$confirm" =~ ^[Yy]$ ]]; then
  if [ -f "$vault_pwd_file" ]; then
    rm "$vault_pwd_file"
  fi

  if [ -f "$secrets_file" ]; then
    rm "$secrets_file"
  fi

  # TODO: 
  # - input argument for vault pwd file
  # - create vault pwd file
  # - input argument for secret file
  # - create ansible secret file (remember variable name = "encrypted_db_pass")
  # - hash secret file using vault password file

else
  echo "Cancelled"
  exit 1
fi	
