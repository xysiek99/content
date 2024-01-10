variable "linode_config" {
  description = "Configuration map for the Linode instance"
  type        = map(string)
}

variable "append_to_file" {
  description = "Decide if we should append to the file or overwrite it"
  type        = bool
}

variable "add_ansible_vars" {
  description = "Flag to determine if additional ansible vars should be added"
  type        = bool
}
