#!/bin/bash
#===================================================================================
#
# FILE: env.sh
#
# USAGE: createvhostwithfpmpool.sh
#
# DESCRIPTION: Copy .env.example file and create .env file with replaced placeholder values from environment.
#
#===================================================================================

cp .env.example .env

sed -i "s|%WP_CONFIG_DB_NAME%|$WP_CONFIG_DB_NAME|g" .env
sed -i "s|%WP_CONFIG_DB_USER%|$WP_CONFIG_DB_USER|g" .env
sed -i "s|%WP_CONFIG_DB_PASS%|$WP_CONFIG_DB_PASS|g" .env
sed -i "s|%WP_CONFIG_DB_HOST%|$WP_CONFIG_DB_HOST|g" .env

sed -i "s|%WP_CONFIG_EXTRA%|$WP_CONFIG_EXTRA|g" .env

sed -i "s|%WP_PATH%|$WP_PATH|g" .env
sed -i "s|%WP_URL%|$WP_URL|g" .env
sed -i "s|%WP_TITLE%|$WP_TITLE|g" .env
sed -i "s|%WP_ADMIN_USER%|$WP_ADMIN_USER|g" .env
sed -i "s|%WP_ADMIN_PASS%|$WP_ADMIN_PASS|g" .env
sed -i "s|%WP_ADMIN_EMAIL%|$WP_ADMIN_EMAIL|g" .env

sed -i "s|%WP_TESTS_LIB_PATH%|$WP_TESTS_LIB_PATH|g" .env

sed -i "s|%WP_URL%|$WP_URL|g" .env
sed -i "s|%WP_TESTS_CONFIG_DB_NAME%|$WP_TESTS_CONFIG_DB_NAME|g" .env
sed -i "s|%WP_TESTS_CONFIG_DB_USER%|$WP_TESTS_CONFIG_DB_USER|g" .env
sed -i "s|%WP_TESTS_CONFIG_DB_PASS%|$WP_TESTS_CONFIG_DB_PASS|g" .env
sed -i "s|%WP_TESTS_CONFIG_DB_HOST%|$WP_TESTS_CONFIG_DB_HOST|g" .env
