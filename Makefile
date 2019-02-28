
app_name=bplog
version=$(shell grep 'version>' $(CURDIR)/appinfo/info.xml | cut -d'>' -f2 | cut -d'<' -f1)

build_dir=$(CURDIR)/build
cert_dir=$(HOME)/.owncloud

config_dir=../../config
occ=../../occ

appstore_build_dir=$(build_dir)/appstore/$(app_name)
appstore_artifact_dir=$(build_dir)/artifacts/appstore
appstore_package_file=$(appstore_artifact_dir)/$(app_name)

source_build_dir=$(build_dir)/source/$(app_name)
source_artifact_dir=$(build_dir)/artifacts/source
source_package_file=$(source_artifact_dir)/$(app_name)-$(version)

private_key=$(cert_dir)/$(app_name).key
certificate=$(cert_dir)/$(app_name).crt

sign=php -f $(occ) integrity:sign-app --privateKey="$(private_key)" --certificate="$(certificate)"
sign_skip_msg="*** Signing skipped due to missing files."

ifneq (,$(wildcard $(private_key)))
ifneq (,$(wildcard $(certificate)))
ifneq (,$(wildcard $(occ)))
CAN_SIGN=true
endif
endif
endif

.PHONY: all source appstore clean

all: appstore source

clean:
	rm -rf $(build_dir)

source:
	rm -rf $(source_build_dir) $(source_artifact_dir)
	mkdir -p $(source_build_dir) $(source_artifact_dir)
	rsync -r . $(source_build_dir) \
	--exclude=/.git \
	--exclude=/.gitignore \
	--exclude=/build/ \
	--exclude=/client/ \
	--exclude=/tools/ \
	--exclude=/test
ifdef CAN_SIGN
	mv $(config_dir)/config.php $(config_dir)/config-2.php
	$(sign) --path "$(source_build_dir)"
	mv $(config_dir)/config-2.php $(config_dir)/config.php
else
	@echo $(sign_skip_msg)
endif
	tar -czf $(source_package_file).tar.gz -C $(source_build_dir)/../ $(app_name)

appstore:
	rm -rf $(appstore_build_dir) $(appstore_artifact_dir)
	mkdir -p $(appstore_build_dir) $(appstore_artifact_dir)
	rsync -r . $(appstore_build_dir) \
	--exclude=/.git \
	--exclude=/.gitignore \
	--exclude=/build/ \
	--exclude=/screenshots/ \
	--exclude=/client/ \
	--exclude=/tools/ \
	--exclude=/Makefile
ifdef CAN_SIGN
	mv $(config_dir)/config.php $(config_dir)/config-2.php
	$(sign) --path="$(appstore_build_dir)"
	mv $(config_dir)/config-2.php $(config_dir)/config.php
else
	@echo $(sign_skip_msg)
endif
	tar -czf $(appstore_package_file).tar.gz -C $(appstore_build_dir)/../ $(app_name)
