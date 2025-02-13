<?php
$DatabaseUsers = [];
$DatabaseUsers[] = ["nome" => "admin", "senha" => "123"];
$user = false;
$vendas = 0;
$itensVendidos = [];
function registro()
{
    do {
        global $DatabaseUsers;
        echo "Registro de usuários: \n";
        $userRegistro = readline("Nome de usuário: ");
        $password = readline("Senha: ");
        $DatabaseUsers[] = ["nome" => $userRegistro, "senha" => $password];
        $msg = "Usuario: " . "$userRegistro" . "Senha:  " . "$password" . "\n";
        file_put_contents('usuarios.txt ', $msg, FILE_APPEND);
        echo "usuario registrado com sucesso, acesso ao sistema liberado!\n";
        echo "cadastrar outro usuario?\n";
        print_r($DatabaseUsers);
        $userloop = readline("digite 1 para sim ou 2 para não\n");
    } while ($userloop == 1);
    if ($userloop == 2) {
        login();
    }
}

function login()
{
    global $DatabaseUsers;
    global $user;


    $userLogin = readline("Usuário: ");
    $password = readline("Senha: ");
    foreach ($DatabaseUsers as $item) {
        if ($item ["nome"] == $userLogin && $item ["senha"] == $password) {
            $user = $item["nome"];
            return;
        }
    }
    echo "Erro, usuário ou senha incorreto.\n";
    readline('aperte enter para tentar novamente');
    login();
}

// DESLOGAR
function deslogar()
{
    global $user;
    $user = false;
}

//FUNÇÃO VENDER
function vender()
{
    echo "\nVocê está no menu de vendas do sistema";
    do {
        global $user;
        global $vendas;
        echo "\nInsira o produto e o preço:\n";
        $produto = readline("Produto:");
        $preco = readline("Preço:");
        $quantia = readline("Quantia");
        $vendas += $preco;
        global $databaseProducts;
        $databaseProducts[] = [$user, $produto, $preco];
        $msg = "$user vendeu " . $quantia . " " . $produto . " por " . $preco . " R$";
        file_put_contents('historico.txt', $msg, FILE_APPEND);
        echo "realizar outra venda? \n Digite sim ou não.";
        echo "\n";
        $sair = readline();
        system("clear");
    } while ($sair === "sim");
}

// LOGS
function logs()
{
    do {
        echo "Digite user para log de usuarios: \nHist para o historico de vendas: \nOu digite sair para voltar ao menu inicial: \n";
        $choice = readline();
        if ($choice === "user") {
            logusuarios();
        } elseif ($choice === "hist") {
            function historico()
            {
                echo "Aqui esta a log do historico";
                file_get_contents('historico.txt');

            }
        }
    } while ($choice != "sair");
}

//log user
function logusuarios()
{
    echo "Aqui está a log de usuarios!";
    file_get_contents('usuarios.txt');
}

// Login page
function verificarlogin($temlog)
{
    if ($temlog == 1) {
        login();
    } elseif ($temlog == 2) {
        registro();
    } else {
        echo "Opção invalida"
        ($temlog = 'invalido');
    }
}


// MENU PRINCIPAL
while (true) {
    global $user;
    if ($user) {
        echo "Bem vindo ao sistema\n";
        echo "Digite uma das opções a seguir:\n";
        echo "1 = Vender \n";
        echo "2 = Cadastrar novo usuário \n";
        echo "3 = Verificar a Log \n";
        echo "4 = Deslogar \n";
        $escolhaMenu = readline("digite:");
        if ($escolhaMenu == 1) {
            vender();
        } elseif ($escolhaMenu == 2) {
            registro();
        } elseif ($escolhaMenu == 3) {
            logs();
        } elseif ($escolhaMenu == 4) {
            deslogar();
        } else {
            echo "opção invalida";
        }

    } else {
        echo "PGR SISTEMA DE ADMINISTRAÇÃO\n";
        echo "1 => Login \n2 => Registro \n";
        $temlog = readline();
        verificarlogin($temlog);

    }
}
