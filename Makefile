.PHONY: dev-server

dev-server:
	docker run --rm -it --entrypoint /dev-server-entrypoint.sh -p 8001:80 \
	-v $(shell pwd):/workspace ghcr.io/atas/ssg-builder:latest
