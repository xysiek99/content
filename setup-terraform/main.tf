resource "linode_instance" "php_vm" {
  label           = var.instance_name
  type            = "g6-nanode-1"
  image           = "linode/debian11"
  region          = "eu-central"
  authorized_keys = [var.ssh_public_key]

  provisioner "local-exec" {
    command = templatefile("config-ssh-wikijs.tpl", {
      custom_hostname = var.instance_name
      hostname        = self.ip_address,
      user            = "root",
      identityfile    = var.wikijs_public_key_path
    })
    interpreter = ["bash", "-c"]
  }
}