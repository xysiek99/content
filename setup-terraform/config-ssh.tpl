cp ~/.ssh/config ~/.ssh/config_$(date +%m-%d-%y_%H%M).backup

if grep -q "^Host ${custom_hostname}$" ~/.ssh/config; then
  awk "/^Host ${custom_hostname}$/{flag=1;next} /^Host /{flag=0} !flag" ~/.ssh/config > ~/.ssh/config.temp
  mv ~/.ssh/config.temp ~/.ssh/config
fi

cat << EOF >> ~/.ssh/config
Host ${custom_hostname}
  HostName ${hostname}
  User ${user}
  IdentityFile ${identityfile}
EOF
