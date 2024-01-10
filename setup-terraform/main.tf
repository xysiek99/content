module "php_vm" {
  source = "./module_linode_vm"
  linode_config = {
    instance_name               = "php_vm"
    root_password               = var.root_password
    technician_username         = var.technician_username
    technician_public_key_path  = var.technician_public_key_path
    technician_private_key_path = var.technician_private_key_path
    ansible_host_file           = var.ansible_host_file
    linode_token                = var.linode_token
  }
  append_to_file   = false
  add_ansible_vars = false
}

module "docker_registry_vm" {
  source = "./module_linode_vm"
  linode_config = {
    instance_name               = "docker_registry_vm"
    root_password               = var.root_password
    technician_username         = var.technician_username
    technician_public_key_path  = var.technician_public_key_path
    technician_private_key_path = var.technician_private_key_path
    ansible_host_file           = var.ansible_host_file
    linode_token                = var.linode_token
  }
  append_to_file   = true
  depends_on       = [module.php_vm]
  add_ansible_vars = true
}
