#!/usr/bin/env bash

ssh_dir="$HOME/.ssh"
public_key="$ssh_dir/inzynier_key.pub"
private_key="$ssh_dir/inzynier_key"

# If key pair exist, script will quit
if [ -f "$public_key" ] && [ -f "$private_key" ]; then
  echo "Found exisitng key pair in ~/.ssh/"
  exit 0
fi

# If only one of keys is present, script will ask to clean it and recreate key pair or to abort
read -p "Key pair not found. Do you want to recreate key pair? (Y/N): " confirm
if [[ "$confirm" =~ ^[Yy]$ ]]; then
  if [ -f "$public_key" ]; then
    rm "$public_key"
  fi

  if [ -f "$private_key" ]; then
    rm "$private_key"
  fi

  echo "Creating new ssh key pair"
  ssh-keygen -b 4096 -t rsa -f "$private_key" -q -N ""
  exit 0
else
  echo "Cancelled"
  exit 1
fi
