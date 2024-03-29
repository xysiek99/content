cat << EOF > ${groupvarsfile}
server_username: "{{ ansible_user }}"

# Global settings for dockerized php application 
php_application:
  image_name: php_application
  mount_location: "/var/www/html"

# Global settings for private docker registry
docker_registry:
  ip: "{{ groups['docker_registry_vm'][0] }}"
  port: 5000
  host: localhost
  container_name: registry
EOF