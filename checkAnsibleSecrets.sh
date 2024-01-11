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

  # Input vault password (remove spaces if necessary) and write it to vault password file
  read -s -p "Enter vault password (no spaces will be allowed): " vault_pwd
  vault_pwd="${vault_pwd// /}"
  echo "$vault_pwd" > "$vault_pwd_file"  

  # Input databse configuration password (remove spaces if necessary) and write it to ansible secrets file for role
  read -s -p "Enter databse configuration password (no spaces will be allowed): " db_secret_pwd
  db_secret_pwd="${db_secret_pwd// /}"
  echo "encrypted_db_pass: $db_secret_pwd" > "$secrets_file"

  # Encrypt database password with ansible vault
  ansible-vault encrypt $secrets_file --vault-password-file $vault_pwd_file

  exit 0

else
  echo "Cancelled"
  exit 1
fi	
