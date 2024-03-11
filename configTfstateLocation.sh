#!/usr/bin/env bash

backend_file_location=""
tfstate_file_loaction=""

# Parse command-line arguments
for arg in "$@"; do
  case $arg in
    -backend_file_location=*)
      backend_file_location="${arg#*=}"
      ;;
    -tfstate_file_loaction=*)
      tfstate_file_loaction="${arg#*=}"
      ;;
    *)
      echo "Unknown argument: $arg"
      exit 1
      ;;
  esac
done

# Checking if both files are provided
if [ -z "$backend_file_location" ] || [ -z "$tfstate_file_loaction" ]; then
  echo "Missing arguments. Usage: $0 -backend_file_location=<backend_file_location> -tfstate_file_loaction=<tfstate_file_loaction>"
  exit 1
fi

cat > "$backend_file_location" <<EOF
terraform {
  backend "local" {
    path = "$tfstate_file_loaction"
  }
}
EOF

exit 0