
# You would only need to use these if you want to build your own custom builder image.
# Otherwise, by default the workflow uses the pre-built image from ghcr.io/atas/ssg-builder:latest

.PHONY: build-local-image update-workflow-image run-local-image

build-local-image:
	docker build system/workflow-image -t atas-ssg-builder:latest

update-workflow-image:
	docker login ghcr.io
	docker buildx build --platform linux/amd64 system/workflow-image -t ghcr.io/atas/ssg-builder:latest
	docker push ghcr.io/atas/ssg-builder:latest

tag-workflow-image:
	docker tag ghcr.io/atas/ssg-builder:latest ghcr.io/atas/ssg-builder:$(shell date +%Y%m%d%H%M)
	docker push ghcr.io/atas/ssg-builder:$(shell date +%Y%m%d%H%M)

run-local-image:
	docker run --rm -it -v $(shell pwd):/github/workspace atas-ssg-builder:latest

