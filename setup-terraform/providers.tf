terraform {
  required_version = ">= 0.12"
  required_providers {
    linode = {
      source = "linode/linode"
    }
  }
}

provider "linode" {
  token = var.linode_token
}