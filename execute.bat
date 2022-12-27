 set /p variable= < .env
 set variable=%variable: =%
cls
echo off
cls
@REM if not %variable%=="python" python pycommand test
set data=''
@REM FOR /F "tokens=1,2* delims= " %%i in ('.env') do set data=%%i > .env.exemple

set var1=python
set var2=php

@Echo OFF
 

SET /p arguments= Bienvenue dans la CLR concept entrer une commande pour demarrer:
echo %arguments%

if %variable%==%var1% python pycommand %arguments%

if %variable%==%var2% php phpcommand %arguments%
