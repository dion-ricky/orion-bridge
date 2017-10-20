@echo off
setlocal enableextensions
cls
set user=root
set password=
for /f "usebackq delims=()" %%a in ("%temp%\location.txt") do @set loc=%%a
for /f "usebackq delims=()" %%b in ("%temp%\directory.txt") do @set directory=%%b
set "mysql=%loc%\mysql\bin"
if exist "%mysql%" (
cd %mysql%
)
:check
set retry=%1
if not %errorlevel% == 0 (
if not "%retry%" == "retry" (
if defined password (
if not "%password:~0,2%" == "-p" (
set "password=-p%password%"
)
)
)
)
mysql.exe -u %user% %password% < "%directory%\data\sql\create.sql" 2>nul
if "%retry%" == "retry" ( exit /b 2 )
if "%retry%" == "input" ( exit /b %errorlevel% )
if %errorlevel% == 1 goto error
goto tables
exit
:error
if not %errorlevel% == 2 (
echo Make sure mysql server is running on your system!
pause
call :check retry
)
if %errorlevel% == 2 (
cls
echo We can't connect to your mysql server! Please provide username and password to connect to mysql server:
set /p "user=Username> "
set /p "password=Password> "
call :check input
)
if %errorlevel% == 1 goto error
goto tables
exit
:tables
set retry=
echo Connected to MySql database with user root
timeout /t 2 /nobreak > nul
mysql.exe -u %user% %password% inventory < "%directory%\data\sql\inventory_db.sql"
echo %user% %password% > "%temp%\up.txt"
cd %directory%
start connection.bat&&exit