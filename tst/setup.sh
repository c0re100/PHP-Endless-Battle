docker rm -f $(docker ps --filter="name=ebs" -aq);
docker-compose -p EBS build;
docker-compose -p EBS up -d;
