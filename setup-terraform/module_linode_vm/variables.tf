variable "linode_config" {
  description = "Configuration map for the Linode instance"
  type        = map(string)
}

variable "append_to_file" {
  description = "Flag to determine if file should be overwritten or to append content to it"
  type        = bool
}

variable "add_ansible_vars" {
  description = "Flag to determine if additional ansible vars should be added"
  type        = bool
}
