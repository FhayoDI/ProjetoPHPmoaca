<?php
$DatabaseUsers = [];
$DatabaseUsers[] = ["nome" => "admin", "senha" => "123"];
$produtos = [];
$user = false;
$vendas = 0;
$caixa = 0;

function limparTela() {
    system(PHP_OS_FAMILY === 'Windows' ? 'cls' : 'clear');
}

function registro() {
    do {
        global $DatabaseUsers;
        echo "Registro de usuários: \n";
        $userRegistro = readline("Nome de usuário: ");
        $password = readline("Senha: ");
        $DatabaseUsers[] = ["nome" => $userRegistro, "senha" => $password];
        $msg = $userRegistro . ":" . $password . "\n";
        file_put_contents('usuarios.txt', $msg, FILE_APPEND);
        echo "Usuário registrado com sucesso!\n";
        sleep(1);
        limparTela();

        echo "Cadastrar outro usuário? (1 para Sim / 2 para Não)\n";
        $userloop = readline();
    } while ($userloop == 1);

    if ($userloop == 2) {
        login();
    }
}

function login() {
    global $DatabaseUsers, $user;

    $userLogin = readline("Usuário: ");
    $password = readline("Senha: ");

    foreach ($DatabaseUsers as $item) {
        if ($item["nome"] == $userLogin && $item["senha"] == $password) {
            $user = $item["nome"];
            $msglog = "$user logou " . date("Y-m-d H:i:s \n");
            file_put_contents('usuarios.txt', $msglog, FILE_APPEND);

            echo "Login bem-sucedido!\n";
            sleep(1);
            limparTela();
            return;
        }
    }
    echo "Erro, usuário ou senha incorretos.\n";
    readline('Pressione Enter para tentar novamente...');
    limparTela();
    login();
}

function deslogar() {
    global $user;
    $user = false;
    echo "Deslogado com sucesso!\n";
    sleep(1);
    limparTela();
}

function vender() {
    do {
        global $user, $vendas, $caixa, $produtos;

        echo "Você está no menu de vendas\n";
        $idProduto = readline("Digite o ID do produto: ");

        if (!isset($produtos[$idProduto])) {
            echo "Produto não encontrado!\n";
            continue;
        }

        $produto = $produtos[$idProduto]['nome'];
        $preco = $produtos[$idProduto]['preco'];

        $quantia = readline("Quantidade: ");
        $pagamento = readline("Quanto o cliente pagou? ");

        if ($pagamento < $preco * $quantia) {
            echo "Dinheiro insuficiente!\n";
            continue;
        }

        $troco = $pagamento - ($preco * $quantia);

        if ($troco > $caixa) {
            echo "Não temos troco suficiente. A venda será cancelada!\n";
            continue;
        }

        $caixa += $preco * $quantia;
        $vendas += $preco * $quantia;

        $msgprodutolog = "$user vendeu $quantia x $produto por R$ " . ($preco * $quantia) . " em " . date("Y-m-d H:i:s \n");
        file_put_contents('historico.txt', $msgprodutolog, FILE_APPEND);

        echo "Venda registrada com sucesso! Troco: R$ $troco\n";

        sleep(1);
        limparTela();

        echo "Realizar outra venda? (sim/não): ";
        $sair = readline();
    } while (strtolower($sair) === "sim");
}

function logs() {
    do {
        echo "1 - Log de usuários\n2 - Histórico de vendas\n3 - Voltar ao menu inicial\n";
        $choice = readline();

        if ($choice == "1") {
            logusuarios();
        } elseif ($choice == "2") {
            loghist();
        } elseif ($choice == "3") {
            echo "Saindo...\n";
            sleep(1);
            limparTela();
            return;
        } else {
            echo "Opção inválida!\n";
        }
    } while (true);
}

function consultar() {
    global $produtos;
    echo "Produtos cadastrados:\n";
    foreach ($produtos as $id => $produto) {
        echo "ID: $id | Nome: " . $produto['nome'] . " | Preço: R$ " . $produto['preco'] . "\n";
    }
    readline("Pressione Enter para continuar...");
    limparTela();
}

function cadastrar() {
    global $produtos;

    echo "Cadastro de produtos\n";
    $nome = readline("Nome do produto: ");
    $preco = readline("Preço do produto: ");

    $id = count($produtos) + 1;
    $produtos[$id] = ["nome" => $nome, "preco" => $preco];

    echo "Produto cadastrado com sucesso!\n";

    sleep(1);
    limparTela();

    echo "Adicionar outro produto? (1 para Sim / 2 para Não)\n";
    $choice = readline();
    if ($choice == "1") {
        cadastrar();
    }
}

function produtos() {
    echo "1 - Consultar produtos\n2 - Adicionar produto\n";
    $choice = readline();

    if ($choice == "1") {
        consultar();
    } elseif ($choice == "2") {
        cadastrar();
    }
}

function loghist() {
    echo file_get_contents('historico.txt');
    readline("Pressione Enter para continuar...");
    limparTela();
}

function logusuarios() {
    echo file_get_contents('usuarios.txt');
    readline("Pressione Enter para continuar...");
    limparTela();
}

function verificarlogin($temlog) {
    if ($temlog == 1) {
        login();
    } elseif ($temlog == 2) {
        registro();
    } else {
        echo "Opção inválida!\n";
    }
}

while (true) {
    global $user, $caixa;

    if ($user) {
        if ($caixa == 0) {
            $caixa = readline("Quantos reais tem em caixa? ");
        }

        echo "Bem-vindo, $user! Caixa atual: R$ $caixa\n";
        echo "1 - Vender\n2 - Cadastrar usuário\n3 - Ver logs\n4 - Gerenciar produtos\n5 - Deslogar\n";
        $escolhaMenu = readline("Digite a opção: ");

        if ($escolhaMenu == "1") {
            vender();
        } elseif ($escolhaMenu == "2") {
            registro();
        } elseif ($escolhaMenu == "3") {
            logs();
        } elseif ($escolhaMenu == "4") {
            produtos();
        } elseif ($escolhaMenu == "5") {
            deslogar();
        } else {
            echo "Opção inválida!\n";
        }
    } else {
        echo "SISTEMA DE ADMINISTRAÇÃO PGR\n";
        echo "1 - Login\n2 - Registro\n";
        $temlog = readline();
        verificarlogin($temlog);
    }
}
