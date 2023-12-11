.PHONY: dev-server

CONTAINER_IMAGE := $(shell grep 'image:' .github/workflows/build-deploy.yml | sed -e 's/image://g' | tr -d ' \t')

# Define a variable for the port number
DEV_SERVER_PORT := 8002

dev-server:
	@echo "Starting dev server on image $(CONTAINER_IMAGE) at\n-----------\nhttp://localhost:$(DEV_SERVER_PORT)\n-----------"
	@chmod 777 tmp
	docker run --rm -it --entrypoint /dev-server-entrypoint.sh -p $(DEV_SERVER_PORT):80 \
	-v $(shell pwd):/workspace $(CONTAINER_IMAGE)
