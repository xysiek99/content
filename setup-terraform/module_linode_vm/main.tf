terraform {
  required_providers {
    linode = {
      source = "linode/linode"
    }
  }
}

resource "linode_instance" "instance" {
  label     = var.linode_config["instance_name"]
  type      = "g6-nanode-1"
  image     = "linode/debian11"
  region    = "eu-central"
  root_pass = var.linode_config["root_password"]

  provisioner "remote-exec" {
    inline = [
      "useradd -m -s /bin/bash -G sudo ${var.linode_config["technician_username"]}",
      "mkdir /home/${var.linode_config["technician_username"]}/.ssh",
      "echo '${trimspace(file(var.linode_config["technician_public_key_path"]))}' > /home/${var.linode_config["technician_username"]}/.ssh/authorized_keys",
      "chown -R ${var.linode_config["technician_username"]}:${var.linode_config["technician_username"]} /home/${var.linode_config["technician_username"]}/.ssh",
      "chmod 700 /home/${var.linode_config["technician_username"]}/.ssh",
      "chmod 600 /home/${var.linode_config["technician_username"]}/.ssh/authorized_keys",
      "echo '${var.linode_config["technician_username"]} ALL=(ALL) NOPASSWD:ALL' | sudo tee -a /etc/sudoers.d/${var.linode_config["technician_username"]}",
      "hostnamectl set-hostname ${replace(var.linode_config["instance_name"], "_", "-")}",
      "systemctl restart ssh"
    ]

    connection {
      type     = "ssh"
      user     = "root"
      password = var.linode_config["root_password"]
      host     = self.ip_address
    }
  }

  provisioner "local-exec" {
    command = templatefile("config-ssh.tpl", {
      custom_hostname = var.linode_config["instance_name"],
      hostname        = self.ip_address,
      user            = var.linode_config["technician_username"],
      identityfile    = var.linode_config["technician_private_key_path"]
    })
    interpreter = ["bash", "-c"]
  }

  provisioner "local-exec" {
    command = templatefile("create-ansible-hosts.tpl", {
      redirect_operator = var.append_to_file ? ">>" : ">",
      hostsfile         = var.linode_config["ansible_host_file"],
      hostgroup         = var.linode_config["instance_name"],
      hostname          = self.ip_address,
      user              = var.linode_config["technician_username"],
      identityfile      = var.linode_config["technician_private_key_path"],
      add_ansible_vars  = var.add_ansible_vars
    })
    interpreter = ["bash", "-c"]
  }
}
