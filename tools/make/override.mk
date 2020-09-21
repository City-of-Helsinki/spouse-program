CLI_SERVICE=php
CLI_USER=wodby
DOCKER_PROJECT_ROOT=/var/www/html

INSTANCE_prod_HOST=node-019e92fe-9d92-484d-8c34-5a19091f0f0b.wod.by
INSTANCE_prod_USER=wodby
INSTANCE_prod_OPTS=-o port=31230 $(SSH_OPTS)
INSTANCE_prod_EXTRA=-t "cd /var/www/html; bash -l"

INSTANCE_test_HOST=node-1f9f9f03-bffd-4eda-b32b-c1785c87d8f3.wod.by
INSTANCE_test_USER=$(INSTANCE_prod_USER)
INSTANCE_test_OPTS=-o port=31253 $(SSH_OPTS)
INSTANCE_test_EXTRA=$(INSTANCE_prod_EXTRA)
