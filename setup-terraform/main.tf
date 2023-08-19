resource "linode_instance" "php_vm" {
  label           = var.instance_name
  type            = "g6-nanode-1"
  image           = "linode/debian11"
  region          = "eu-central"
  authorized_keys = [trimspace(file(var.ssh_public_key_path))]

  provisioner "remote-exec" {
    inline = [
      "useradd -m -s /bin/bash -G sudo ${var.technician_username}",

      "mkdir /home/${var.technician_username}/.ssh",
      "echo '${trimspace(file(var.technician_public_key_path))}' > /home/${var.technician_username}/.ssh/authorized_keys",
      "chown -R ${var.technician_username}:${var.technician_username} /home/${var.technician_username}/.ssh",
      "chmod 700 /home/${var.technician_username}/.ssh",
      "chmod 600 /home/${var.technician_username}/.ssh/authorized_keys",

      "echo '${var.technician_username} ALL=(ALL) NOPASSWD:ALL' | sudo tee -a /etc/sudoers.d/${var.technician_username}",
      "systemctl restart ssh"
    ]

    connection {
      type        = "ssh"
      user        = "root"
      private_key = file(var.ssh_private_key_path)
      host        = self.ip_address
    }
  }

  provisioner "local-exec" {
    command = templatefile("config-ssh-wikijs.tpl", {
      custom_hostname = var.instance_name,
      hostname        = self.ip_address,
      user            = var.technician_username,
      identityfile    = var.technician_private_key_path
    })
    interpreter = ["bash", "-c"]
  }

  provisioner "local-exec" {
    command = templatefile("create-ansible-hosts.tpl", {
      hostsfile    = var.ansible_host_file,
      hostgroup    = var.instance_name,
      hostname     = self.ip_address,
      user         = var.technician_username,
      identityfile = var.technician_private_key_path
    })
    interpreter = ["bash", "-c"]
  }
}