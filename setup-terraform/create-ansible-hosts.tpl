cat << EOF > ${hostsfile}
[${hostgroup}]
${hostname}

[${hostgroup}:vars]
ansible_user=${user}
ansible_ssh_private_key_file=${identityfile}
EOF