<?php
//login
// Registro
function registro(){
    global $DatabaseUsers;
    global $password;
    echo "Registro de usuários: \n";
    $userRegistro = readline("Nome de usuário");
    $password = readline("Senha");
    $DatabaseUsers[]=[$userRegistro, $password];
    $msg = "$userRegistro" . "$password";
    file_put_contents('usuarios.txt ', $msg);
}
//FUNÇÃO VENDER
function vender() {
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
    $databaseProducts[]= [$user,$produto, $preco];
    $msg = "$user vendeu " . $quantia." " . $produto . " por " . $preco . " R$";
    file_put_contents('historico.txt', $msg, FILE_APPEND);
    echo "realizar outra venda? \n Digite sim ou não.";
    echo "\n";
    $sair = readline();
    system("clear");
} while ($sair === "sim");
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
    if ($escolhaMenu == 2);{
        registro();
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
