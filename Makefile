VERSION=$(shell git tag | tail -1)

make:
	@echo make clean
	@echo make composer
	@echo make dist

clean:
	rm -rf	dist
	rm -rf	docs/html docs/latex
	rm -rf	vendor		examples/vendor
	rm -f	composer.lock	examples/composer.lock

composer:
	composer install
	cd examples
	composer install

dist:
	mkdir -p dist/simphplist-${VERSION}
	cp -r src README.rst composer.json dist/simphplist-${VERSION}
	tar -czvf dist/simphplist-${VERSION}.tar.gz dist/simphplist-${VERSION}
