cat << EOF >> ~/.ssh/config

Host ${custom_hostname}
  HostName ${hostname}
  User ${user}
  IdentityFile ${identityfile}
EOF
