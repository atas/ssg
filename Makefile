.PHONY: dev-server

CONTAINER_IMAGE := $(shell grep 'image:' .github/workflows/build-deploy.yml | sed -e 's/image://g' | tr -d ' \t')

dev-server:
	@echo "Starting dev server on image $(CONTAINER_IMAGE)"
	docker run --rm -it --entrypoint /dev-server-entrypoint.sh -p 8001:80 \
	-v $(shell pwd):/workspace $(CONTAINER_IMAGE)
