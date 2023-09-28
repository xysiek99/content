HOSTBLOCK="[${hostgroup}]\n${hostname}\n"
VARSBLOCK="[all:vars]\nansible_user=${user}\nansible_ssh_private_key_file=${identityfile}\n"

echo -e $HOSTBLOCK ${redirect_operator} ${hostsfile}

%{ if add_ansible_vars ~}
  echo -e $VARSBLOCK >> ${hostsfile}
%{ endif ~}
