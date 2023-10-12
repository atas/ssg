
build-local-image:
	docker build system/workflow-image -t atas-ssg-builder:latest

update-workflow-image:
	docker login ghcr.io
	docker buildx build --platform linux/amd64 system/workflow-image -t ghcr.io/atas/ssg-builder:latest
	docker push ghcr.io/atas/ssg-builder:latest


.PHONY: run-local-image

run-local-image:
	docker run --rm -it -v $(shell pwd):/github/workspace atas-ssg-builder:latest

