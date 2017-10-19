@echo off
for /f "usebackq delims=()" %%a in ("%temp%\directory.txt") do @set loc=%%a
cd %loc%
setlocal enableextensions
:check_permission
cls
echo Administrative permissions required. Detecting permissions...
net session > nul 2>&1
if %errorlevel% == 0 (
	echo Administrative permissions confirmed.
	timeout /t 2 /nobreak > nul
	cls
) else (
	echo Failure: Current permission inadequate.
	pause > nul
	goto :EOF
)
call :errormaker
goto main
:copy
if defined drive (
echo ^(%drive:~0,-17%^) > "%temp%\location.txt"
xcopy "data\inventory" "%drive%" /I /E
goto :EOF
) else ( goto fail )
goto :EOF
:fail
echo.
echo We could not found XAMPP installation directory on your system.
echo Please type in your XAMPP installation directory below:
set /p "ask=> "
if exist "%ask%" (
set "drive=%ask%\htdocs\inventory"
call :copy
) else (
set drive=
)
goto :EOF
)
goto :EOF
:errormaker
exit /B 2
:main
echo ################################################################################
echo                             SHOP INVENTORY INSTALLER
echo                           THIS PROGRAM REQUIRES XAMPP
echo.
echo                      INSTALLER WILL COPY FILES AND DATABASE
echo                       TO YOUR XAMPP INSTALLATION DIRECTORY
echo.
echo ################################################################################
pause
echo Checking XAMPP installation directory...
for /f "tokens=3" %%a in ('diskpart /s script.scr ^| findstr /c:Volume') do call :drive %%a
:database
start database.bat&&exit
:exit
exit
:drive
set var=%1
if not defined var ( set var=Ltr )
if defined var if not %var% == Ltr (
if exist "%var%:\xampp" (
echo XAMPP Installation directory detected on %var%:\xampp
set "drive=%var%:\xampp\htdocs\inventory"
goto copy
) else if exist "%var%:\Program Files\xampp\" (
echo XAMPP Installation directory detected on %var%:\Program Files\xampp
set "drive=%var%:\Program Files\xampp\htdocs\inventory"
) else (
exit /b 2
)
)