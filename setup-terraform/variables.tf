variable "linode_token" {
  type        = string
  sensitive   = true
  description = "Access token to linode account"
}

variable "instance_name" {
  type = string
  default = "php_app_vm"
}

variable "root_pass" {
  type        = string
  default     = "t4_test"
}

variable "ssh_public_key" {
  type        = string
  sensitive   = true
  description = "Key for ssh authentication"
}

variable "wikijs_public_key_path" {
  type    = string
  default = "~/.ssh/wikijs_user_key.pub"
}