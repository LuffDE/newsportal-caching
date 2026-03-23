@echo off
SETLOCAL ENABLEDELAYEDEXPANSION

:: === Default Compose Files ===
SET DC_DEV=.\docker\docker-compose.yml
SET DC_TEST=.\docker\docker-compose-test-ci.yml
SET DC_STAGING=.\docker\docker-compose-staging.yml
SET DC_PROD=.\docker\docker-compose-prod.yml

SET PROJECT_NAME=newsPortal

:: === Load environment files ===
CALL :loadEnv .env
CALL :loadEnv .env.local

:: === Set DC_ENV with selected vars ===
SET DC_ENV=HOST_UID=1000 HOST_GID=1000 WEB_PORT_HTTP=%WEB_PORT_HTTP% WEB_PORT_SSL=%WEB_PORT_SSL% MYSQL_DATABASE=%MYSQL_DATABASE_NAME% MYSQL_USER=%MYSQL_USER_NAME% MYSQL_PASSWORD=%MYSQL_USER_PW% MYSQL_VERSION=%MYSQL_VERSION% INNODB_USE_NATIVE_AIO=%INNODB_USE_NATIVE_AIO% SQL_MODE=%SQL_MODE% MYSQL_ROOT_PASSWORD=%MYSQL_ROOT_PW% MYSQL_PORT=%MYSQL_PORT%

:: === Command routing ===
IF "%1"=="" GOTO :help
IF "%1"=="help" GOTO :help

:: Common environments
IF "%1"=="build" GOTO :build
IF "%1"=="build-test" GOTO :build_test
IF "%1"=="build-staging" GOTO :build_staging
IF "%1"=="build-prod" GOTO :build_prod

IF "%1"=="start" GOTO :start
IF "%1"=="start-test" GOTO :start_test
IF "%1"=="start-staging" GOTO :start_staging
IF "%1"=="start-prod" GOTO :start_prod

IF "%1"=="stop" GOTO :stop
IF "%1"=="stop-test" GOTO :stop_test
IF "%1"=="stop-staging" GOTO :stop_staging
IF "%1"=="stop-prod" GOTO :stop_prod

IF "%1"=="down" GOTO :down
IF "%1"=="down-test" GOTO :down_test
IF "%1"=="down-staging" GOTO :down_staging
IF "%1"=="down-prod" GOTO :down_prod

:: Restart
IF "%1"=="restart" GOTO :restart
IF "%1"=="restart-test" GOTO :restart_test
IF "%1"=="restart-staging" GOTO :restart_staging
IF "%1"=="restart-prod" GOTO :restart_prod

:: Misc
IF "%1"=="migrate" GOTO :migrate
IF "%1"=="phpunit" GOTO :phpunit

ECHO Unknown command: %1
GOTO :help

:: --- Core Commands ---

:build
CALL :with_env docker compose -f %DC_DEV% build
GOTO :EOF

:build_prod
CALL :with_env docker compose -f %DC_PROD% build
GOTO :EOF

:start
CALL :with_env docker compose -f %DC_DEV% up -d
GOTO :EOF

:start_prod
@REM CALL :loadEnv .env.prod
CALL :with_env docker compose -f %DC_PROD% up -d
GOTO :EOF

:stop
CALL :with_env docker compose -f %DC_DEV% stop
GOTO :EOF

:stop_prod
CALL :loadEnv .env.prod
CALL :with_env docker compose -f %DC_PROD% %PROJECT_NAME% stop
GOTO :EOF

:down
CALL :with_env docker compose -f %DC_DEV% down
GOTO :EOF

:down_prod
CALL :loadEnv .env.prod
CALL :with_env docker compose -f %DC_PROD% %PROJECT_NAME% down
GOTO :EOF

:: --- Helper function to load .env files ---
:loadEnv
IF EXIST %1 (
  FOR /F "usebackq delims=" %%A IN (`type %1`) DO (
    SET "LINE=%%A"
    SET "VAR=!LINE:~0,1!"
    IF NOT "!VAR!"=="#" (
      FOR /F "tokens=1,2 delims==" %%B IN ("!LINE!") DO SET %%B=%%C
    )
  )
)
GOTO :EOF

:help
ECHO.
ECHO Available Commands:
ECHO -------------------
ECHO build               - Build dev environment
ECHO build-prod          - Build prod environment
ECHO start               - Start dev environment
ECHO start-prod          - Start prod environment
ECHO stop                - Stop dev environment
ECHO stop-prod           - Stop prod environment
ECHO down                - Remove dev containers
ECHO down-prod           - Remove prod containers
ECHO.
GOTO :EOF

:with_env
:: Übergibt DC_ENV als echte ENV-Vars an den folgenden Befehl
SETLOCAL ENABLEDELAYEDEXPANSION

:: Manuell setzen (nach Bedarf erweitern)
SET HOST_UID=1000
SET HOST_GID=1000
SET WEB_PORT_HTTP=%WEB_PORT_HTTP%
SET WEB_PORT_SSL=%WEB_PORT_SSL%
SET MYSQL_DATABASE=%MYSQL_DATABASE_NAME%
SET MYSQL_USER=%MYSQL_USER_NAME%
SET MYSQL_PASSWORD=%MYSQL_USER_PW%
SET MYSQL_VERSION=%MYSQL_VERSION%
SET INNODB_USE_NATIVE_AIO=%INNODB_USE_NATIVE_AIO%
SET SQL_MODE=%SQL_MODE%
SET MYSQL_ROOT_PASSWORD=%MYSQL_ROOT_PW%
SET MYSQL_PORT=%MYSQL_PORT%

:: Führe übergebenen Befehl aus
%*
ENDLOCAL
GOTO :EOF