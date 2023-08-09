cat << EOF > ${hostsfile}
[phpapp]
${hostname}

[phpapp:vars]
ansible_user=${user}
ansible_ssh_private_key_file=${identityfile}
EOF