docker_compose('docker-compose.yml')
docker_build('wordpress/educacao', '.',
  live_update = [
    sync('.', '/var/www/html')
  ])