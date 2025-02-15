<?php
$DatabaseUsers = [];
$DatabaseUsers[] = ["nome" => "admin", "senha" => "123"];
$produtos = [];

$user = false;
$vendas = 0;
$caixa = 0;

function limparTela(){
system("clear");
}
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
        sleep(0.4);
        echo "cadastrar outro usuario?\n";
        $userloop = readline("digite 1 para sim ou 2 para não\n");
        limparTela();
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
            echo "logado com sucesso!\n";
            sleep(1);
            limparTela();
            return;
        }
    }
    echo "Erro, usuário ou senha incorreto.\n";
    readline('aperte enter para tentar novamente');
    limparTela();
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
        echo "\nInsira o produto ou ID e o preço:\n";
        $produto = readline("Produto ou ID: ");
        $preco = readline("Preço: ");
        $quantia = readline("Quantia: ");
        limparTela();
        $pagamento = readline("Quanto o cliente pagou? \n");
        if ($pagamento > $caixa) {
            echo "Não temos troco, a venda será cancelada! ";
            limparTela();
            return;
        }
        $troco = $pagamento - $preco;
        echo "O troco é: $troco \n";
        global $databaseProducts;
        $vendas += $preco;
        $databaseProducts[] = [$user, $produto, $preco];
        $msgprodutolog = $user . " vendeu " . $quantia . " " . $produto . " por  " . $preco . date("Y-m-d H:i:s \n");
        file_put_contents('historico.txt', $msgprodutolog);
        echo "venda registrada com sucesso! \n";
        echo "realizar outra venda? \n Digite 1 para sim ou 2 para não.";
        echo "\n";
        $sair = readline();
        limparTela();

    } while ($sair == "1");
}

// LOGS
function logs()
{
    do {
        echo "Digite 1 para log de usuarios: \nDigite 2  para o historico de vendas: \nOu digite 3 para voltar ao menu inicial: \n";
        $choice = readline();
        if ($choice == "1") {
            limparTela();
            logusuarios();
        } elseif ($choice == "2") {
            limparTela();
            loghist();
        } else if ($choice == 3) {
            echo "saindo\n";
            sleep(0.3);
            limparTela();
        } else {
            echo "opção invalida\n";
            sleep(0.5);
            limparTela();
        }
    } while ($choice != "3");
}

//função consultar
function consultar()
{
    global $produtos;
    echo "Produto e ID \n ";
    print_r($produtos);
}

//função cadastrar
function cadastrar() {
        global $produtos;
        global $id;
        echo "insira o produto e o preço: \n";
        $nome = readline("produto: ");
        $id = count($produtos) +1 ;
        $produtos[$nome] = "$id";
        echo "produtos cadastrados com sucesso!\n";
        sleep(1);
        limparTela();
        echo "adicionar novos produtos? \n 1 para sim \n 2 para não";
        $choice = readline();
        if ($choice == "1") {
            limparTela();
        }

}
// produtos e cadastro
function produtos()
{
    echo "Você deseja consultar ou adicionar produtos?\n";
    $choice = readline("Digite 1 para consultar \n2 para adicionar \n");
    if ($choice == "1") {
        consultar();
    }
    elseif ($choice == "2"){
        cadastrar();
    }
}

//log historico
function loghist()
{
    global $Histlog;
    $Histlog = file_get_contents('historico.txt');
    echo $Histlog;
    readline("enter para prosseguir");
    limparTela();
}

//log user
function logusuarios()
{
    global $Userlog;
    $Userlog = file_get_contents('usuarios.txt');
    echo $Userlog;
    readline("enter para prosseguir");
    limparTela();
}

// Login page
function verificarlogin($temlog)
{
    if ($temlog == 1) {
        login();
    } elseif ($temlog == 2) {
        registro();
    } else {
        echo "Opção invalida";
        limparTela();
    }
}


// MENU PRINCIPAL
while (true) {
    global $user;
    if ($user) {
        if ($caixa == 0 && $user == true) {
            $caixa = readline("quantos reais tem em caixa? \n");
        }
        echo "Olá $user, Você possui: $caixa  em caixa\n";
        echo "Digite uma das opções a seguir:\n";
        echo "1 = Vender \n";
        echo "2 = Cadastrar novo usuário \n";
        echo "3 = Verificar a Log \n";
        echo "4 = Cadastrar produtos/consultar produtos\n";
        echo "5 = Deslogar \n";
        $escolhaMenu = readline("digite:");
        if ($escolhaMenu == 1) {
            vender();
        } elseif ($escolhaMenu == 2) {
            limparTela();
            registro();
        } elseif ($escolhaMenu == 3) {
            limparTela();
            logs();
        } elseif ($escolhaMenu == 4) {
            limparTela();
            produtos();
        } elseif ($escolhaMenu == 5) {
            limparTela();
            deslogar();
        } else {
            echo "opção invalida";
        }

    } else {
        echo "PGR SISTEMA DE ADMINISTRAÇÃO\n";
        echo "1 => Login \n2 => Registro \n";
        $temlog = readline();
        verificarlogin($temlog);
        limparTela();

    }
}
/*
 * pcionais:
Salvar o log em um arquivo .txt.
Quando o sistema é acessado pela primeira vez, é perguntado quanto de dinheiro existe no caixa. Para cada venda realizada, o usuário deverá informar quanto de dinheiro o cliente entregou. Se o cliente deu dinheiro a mais, deve ocorrer uma verificação se existe dinheiro o suficiente em caixa para o troco. Se não for possível devolver troco, a venda é cancelada.
Possibilitar salvar os itens à venda no sistema, com id, nome, preço e estoque. Ao realizar uma venda deverá ser informado o id no lugar do nome e preço, e então verificar se existe em estoque, e se existir, atualizar o estoque após a venda.
No contexto do item anterior, permitir a alteração de algum item (alterar o valor, quantidade em estoque ou deletar).

*/