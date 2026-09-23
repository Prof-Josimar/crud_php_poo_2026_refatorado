@echo off
chcp 65001
rem c:\xampp\mysql\bin\mysqldump -u root --databases --skip-comments aulapdo > .\src\Utils\backup_DB_Com_Dados.sql
rem c:\xampp\mysql\bin\mysqldump -u root --no-data --databases --skip-comments   aulapdo > .\src\Utils\backup_DB_SemDados.sql

set "project_name=Projeto Aulas PHP 2026 Refatorado - %date% %time%"
set "author=Josimar Ribeiro"
set "filename=README.md"
set "date_time=%DATE% %TIME%"
set "logo_url=https://github.com/Prof-Josimar/crud_php_poo_2026_refatorado/blob/main/public/img/vortex_with_text.svg"

REM === Cria o README.md ===
echo # %project_name% > %filename%
echo. >> %filename%


echo. >> %filename%
echo. >> %filename%



echo ## Informações do sistema >> %filename%
echo - Data e hora: %date_time% >> %filename%
echo - Usuário: %USERNAME% >> %filename%
echo - Computador: %COMPUTERNAME% >> %filename%
echo - Diretório atual: %CD% >> %filename%
for /f "tokens=* delims=" %%g in ('git --version') do echo - %%g >> %filename%
echo. >> %filename%

echo ^<img src="%logo_url%" width="300"^> >> %filename%
echo. >> %filename%

REM === Bloco para git status ===
git status --porcelain >> %filename%

REM === Bloco de Download ===
echo. >> %filename%




echo. >> %filename%

echo ## Autor >> %filename%
echo %author% >> %filename%
echo. >> %filename%

set "logo_url=https://github.com/Prof-Josimar/crud_php_poo_2026_refatorado/blob/main/public/img/vortex_with_text.svg"


echo ^<img src="%logo_url%" width="200"^> >> %filename%

:::git init
git add . -v
git commit -m "Commit em  %date% às %time%"
git branch -M main
git push -u origin main

::start "" "https://github.com/Prof-Josimar/crud_php_poo_2026"




::git remote add origin git@github.com:Prof-Josimar/crud_php_poo_2026_refatorado.git
