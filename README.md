# Angenda Telefonica
Para executar este projeto basta ter o PHP 7.4 ou superiro em sua maquina instaldo de forma global, para instalar no windows você deve instalar o PHP você baixa o [Chocolatey](https://chocolatey.org/install)  e executar o comando no powershell como __administrador__:


_Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://chocolatey.org/install.ps1'))_


e logo aṕos a instalação feche a abra novamente o powershell e abra novamente como __administrador__ e execute o comando:

_choco install php_

após baixar esse projeto execute no local do arquivo:

_php -S localhost:8000_

