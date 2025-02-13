<?php
//login
// Registro
function registro()
{
    do {
        global $DatabaseUsers;
        global $password;
        echo "Registro de usuários: \n";
        $userRegistro = readline("Nome de usuário: ");
        $password = readline("Senha: ");
        $DatabaseUsers[] = [$userRegistro, $password];
        $msg = "Usuario: " . "$userRegistro" . "Senha:  " . "$password" . "\n";
        file_put_contents('usuarios.txt ', $msg, FILE_APPEND);
        echo "usuario registrado com sucesso, acesso ao sistema liberado!\n";
        echo "cadastrar outro usuario?\n";
        $userloop = readline("digite sim ou não\n");
        if ($userloop === "sim")
            system("clear");
    } while ($userloop === "sim");
}

//FUNÇÃO VENDER
function vender()
{
    echo "\nVocê está no menu de vendas do sistema";
    do {
        global $user;
        global $produto;
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
        $arquivo = 0;
        $loguser = 0;
        $loghistorico = 0;
        $choice = readline("Digite user para log de usuarios e hist para o historico de vendas!\n Ou digite sair para voltar ao menu inicial");
        if ($choice === "user") {
            function usuarios()
            {

            }
        } elseif ($choice === "hist") {
            function historico()
            {

            }
        }
    } while ($choice != "sair");
}

// MENU PRINCIPAL
do {
    echo "Bem vindo ao sistema";
    echo "Digite uma das opções a seguir:\n";
    echo "1 = Vender \n";
    echo "2 = Cadastrar novo usuário \n";
    echo "3 = Verificar a Log \n";
    echo "4 = Deslogar \n";
    $escolhaMenu = readline("digite:");
    if ($escolhaMenu == 1) {
        vender();
    }
    if ($escolhaMenu == 2)
    {
        registro();
    }
    if ($escolhaMenu == 3) {
        logs();
    }
} while ($escolhaMenu != 4);


$password = 0;
$DatabaseUsers = 0;
$user = 0;
$produto = 0;
$vendas = 0;
$id = 0;
$menuinicial = 0;
$escolhaMenu = 0;
