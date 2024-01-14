#!/usr/bin/env bash

vault_pwd_file=""
secrets_file=""

# Parse command-line arguments
for arg in "$@"; do
  case $arg in
    -vault_pwd_file=*)
      vault_pwd_file="${arg#*=}"
      ;;
    -secrets_file=*)
      secrets_file="${arg#*=}"
      ;;
    *)
      echo "Unknown argument: $arg"
      exit 1
      ;;
  esac
done

# Checking if both files are provided
if [ -z "$vault_pwd_file" ] || [ -z "$secrets_file" ]; then
  echo "Missing arguments. Usage: $0 -vault_pwd_file=<vault_pwd_file> -secrets_file=<secrets_file>"
  exit 1
fi

# If both files are present, script will quit
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

  # Input vault password and db config password (remove spaces if necessary) and write them to files
  read -s -p "Enter vault password (no spaces will be allowed): " vault_pwd
  vault_pwd="${vault_pwd// /}"
  echo "$vault_pwd" > "$vault_pwd_file"
  echo
  read -s -p "Enter database configuration password (no spaces will be allowed): " db_secret_pwd
  db_secret_pwd="${db_secret_pwd// /}"
  echo "encrypted_db_pass: $db_secret_pwd" > "$secrets_file"

  # Encrypt database password with ansible vault
  ansible-vault encrypt "$secrets_file" --vault-password-file "$vault_pwd_file"

  exit 0

else
  echo "Cancelled"
  exit 1
fi
