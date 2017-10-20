@echo off
for /f "usebackq tokens=1,2" %%a in ("%temp%\up.txt") do (
set getuser=%%a
set getpass=%%b
)
set user=%getuser%
setlocal enableextensions
if defined getpass (
set pass=%getpass:~2%
) else (
set pass=
)
for /f "usebackq delims=()" %%a in ("%temp%\location.txt") do @set loc=%%a
cd "%loc%\htdocs\inventory\library"
echo ^<?php > inc.connection.php
echo $myHost = "localhost"; >> inc.connection.php
echo $myUser = "%user%"; >> inc.connection.php
if defined pass (
echo $myPass = '%pass%'; >> inc.connection.php
) else (
echo $myPass = '%pass%'; >> inc.connection.php
)
echo $myDbs = "inventory"; >> inc.connection.php
echo. >> inc.connection.php
echo $koneksidb = mysqli_connect($myHost, $myUser, $myPass); >> inc.connection.php
echo if (! $koneksidb) { >> inc.connection.php
echo 	echo "Failed connection!"; >> inc.connection.php
echo } >> inc.connection.php
echo. >> inc.connection.php
echo mysqli_select_db($koneksidb, $myDbs) or die ("Database not found!"); >> inc.connection.php
echo ?^> >> inc.connection.php
del /q "%temp%\directory.txt"
del /q "%temp%\up.txt"
del /q "%temp%\location.txt"
del /q "%temp%\sudo.vbs"
explorer.exe "%loc%\htdocs\inventory\help\Tutorial"
msg * Installation finished! Please close this window!
echo Installation finished! Please close this window!