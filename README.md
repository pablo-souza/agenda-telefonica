# Angenda Telefonica
Para executar este projeto basta ter o PHP 7.4 ou superiro em sua maquina instaldo de forma global, para instalar no windows você deve instalar o PHP você baixa o [Chocolatey](https://chocolatey.org/install)  e executar o comando no powershell como __administrador__:


_Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://chocolatey.org/install.ps1'))_

e logo aṕos a instalação feche a abra novamente o powershell e abra novamente como __administrador__ e execute o comando:

_choco install php_

para instalar no Ubunto e derivados: 

_sudo apt install software-properties-common_

_sudo add-apt-repository ppa:ondrej/php_

_sudo apt update_

_sudo apt install php8.0 libapache2-mod-php8.0_

__PODE SER NECESSARIO BAIXAR OU HABILITAR A ESTENÇÃO QUE PERMITA CONEXAO PDO AO SQLITE__

no windows digite 

_php --ini_

e ele te mostrara onde encontrar o arquivo

abra o php.ini e procure por

_;extension=pdo_sqlite_

apague o __;__ e salve o arquivo 

após baixar o projeto, abra o terminal e navegue até a pasta do projeto _angenda-telefonica>php_ e execute:

_php -S localhost:8000_

feito isso você pode abrir _angenda-telefonica\index.html_
