<?php
$DatabaseUsers = [];
$DatabaseUsers[] = ["nome" => "admin", "senha" => "123"];
$user = false;
$vendas = 0;
$itensVendidos = [];
$caixa = 0;

function registro()
{
    do {
        global $DatabaseUsers;
        echo "Registro de usuários: \n";
        $userRegistro = readline("Nome de usuário: ");
        $password = readline("Senha: ");
        $DatabaseUsers[] = ["nome" => $userRegistro, "senha" => $password];
        $msg = $userRegistro . ":" . $password . "\n";
        file_put_contents('usuarios.txt', $msg, FILE_APPEND);
        echo "usuario registrado com sucesso, acesso ao sistema liberado!\n";
        echo "cadastrar outro usuario?\n";
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
            $msglog = $user . " logou " . date("Y-m-d H:i:s \n");
            file_put_contents('usuarios.txt', $msglog);
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
        global $caixa;
        echo "\nInsira o produto e o preço:\n";
        $produto = readline("Produto:");
        $preco = readline("Preço:");
        $quantia = readline("Quantia");
        $pagamento = readline("Quanto o cliente pagou? \n");
        if ($pagamento > $caixa) {
            echo "Não temos troco, a venda será cancelada! ";
        return;
        }
        $troco = $pagamento - $preco;
        echo "O troco é \n: $troco";
        global $databaseProducts;
        $vendas += $preco;
        $databaseProducts[] = [$user, $produto, $preco];
        $msgprodutolog = $user . " vendeu " . $quantia . " " . $produto . " por  " . $preco . date("Y-m-d H:i:s \n");
        file_put_contents('historico.txt', $msgprodutolog);
        echo "venda registrada com sucesso";
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
        echo "Digite 1 para log de usuarios: \nDigite 2  para o historico de vendas: \nOu digite 3 para voltar ao menu inicial: \n";
        $choice = readline();
        if ($choice == "1") {
            logusuarios();
        } elseif ($choice == "2") {
            loghist();
        }
        else if ($choice ==3) {
            echo "saindo\n";
            sleep(0.3);
        }
        else {
            echo "opção invalida\n";
        }
    } while ($choice != "3");
}
//log historico
function loghist(){
    global $Histlog;
    $Histlog = file_get_contents('historico.txt');
    echo $Histlog;
}
//log user
function logusuarios(){
    global $Userlog;
    $Userlog = file_get_contents('usuarios.txt');
    echo $Userlog;
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
        if ($caixa == 0 && $user == true){
            $caixa = readline("quantos reais tem em caixa?");
        }
        echo "Bem vindo ao sistema, Você possui: $caixa dinheiros no caixa\n";
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
