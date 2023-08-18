variable "linode_token" {
  type        = string
  sensitive   = true
  description = "Access token to linode account"
}

variable "instance_name" {
  type    = string
  default = "php_app_vm"
}

variable "root_pass" {
  type    = string
  default = "t4_test"
}

variable "ssh_public_key_path" {
  type    = string
  default = "~/.ssh/wikijs_user_key.pub"
}

variable "ssh_private_key_path" {
  type    = string
  default = "~/.ssh/wikijs_user_key"
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
