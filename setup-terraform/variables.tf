# Linode access token

variable "linode_token" {
  type        = string
  sensitive   = true
  description = "Access token to linode account"
}

# Initial password for root user

variable "root_password" {
  type      = string
  sensitive = true
}

# Add technician user and his key

variable "technician_username" {
  type    = string
  default = "inzynier"
}

variable "technician_private_key_path" {
  type    = string
  default = "~/.ssh/inzynier_key"
}

variable "technician_public_key_path" {
  type    = string
  default = "~/.ssh/inzynier_key.pub"
}

# Ansible variable

variable "ansible_host_file" {
  type    = string
  default = "../setup-ansible/inventory/DEV/hosts"
}
