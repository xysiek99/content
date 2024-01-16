module "php_vm" {
  source = "./module_linode_vm"
  linode_config = {
    instance_name               = "${var.infra_environment}_php_vm"
    ansible_instance_name       = "php_vm"
    root_password               = var.root_password
    technician_username         = var.technician_username
    technician_public_key_path  = var.technician_public_key_path
    technician_private_key_path = var.technician_private_key_path
    infra_environment           = var.infra_environment
    linode_token                = var.linode_token
  }
  append_to_file   = false
  add_ansible_vars = false
}

module "docker_registry_vm" {
  source = "./module_linode_vm"
  linode_config = {
    instance_name               = "${var.infra_environment}_docker_registry_vm"
    ansible_instance_name       = "docker_registry_vm"
    root_password               = var.root_password
    technician_username         = var.technician_username
    technician_public_key_path  = var.technician_public_key_path
    technician_private_key_path = var.technician_private_key_path
    infra_environment           = var.infra_environment
    linode_token                = var.linode_token
  }
  append_to_file   = true
  depends_on       = [module.php_vm]
  add_ansible_vars = true
}
