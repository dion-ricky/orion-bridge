@echo off
echo Set objShell = CreateObject("Shell.Application") > %temp%\sudo.vbs
echo args = Right("%*", (Len("%*") - Len("%1"))) >> %temp%\sudo.vbs
echo objShell.ShellExecute "%1", args, "", "runas" >> %temp%\sudo.vbs
cscript %temp%\sudo.vbs