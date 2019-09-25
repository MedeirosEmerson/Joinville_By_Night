<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title></title>
</head>
<body>
<?php 

// Variaveis
$nome = $_POST['lbl_nome'];
$cpf = $_POST['lbl_cpf'];
$telefone = $_POST['lbl_phone'];
$email = $_POST['lbl_email'];
$senha= $_POST['lbl_senha'];

// Conexão
include 'conexao.php';

// Selecionando
$query_select = "SELECT email_cliente FROM epiz_23947514_cookie_store.tb_cliente WHERE email_cliente = '$email'";
$select = mysqli_query($conexao,$query_select);
$array = mysqli_fetch_array($select);
$logarry = $array['email'];

	if ($email == "" || $email == null) {
		echo "<script>alert('Campo email deve ser preenchido!'); location.href = '../../pags/cadastro.php'; </script>";
	} else {
		if ($logarry == $email) {
			echo "<script>alert('Este E-mail já esta cadastrado'); location.href = '../../pags/cadastro.php'; </script>";
			die();
		} else {
			$senha = password_hash($senha, PASSWORD_DEFAULT);
			$query = "INSERT INTO `epiz_23947514_cookie_store`.`tb_cliente`(`id_cliente`, `nome_cliente`, `telefone_cliente`, `email_cliente`, `cpf_cliente`, `senha`) VALUES (null, '$nome', '$telefone', '$email', '$cpf','$senha')";

			$insert = mysqli_query($conexao,$query);

			if ($insert) {
				echo "<script>alert('Usuário Cadastrado com Sucesso!'); location.href = '../../index.php'; </script>";
			} else {
				echo "<script>alert('Erro ao Realizar o Cadastro. Tente novamente'); location.href = '../../pags/cadastro.php'; </script>";
			}
		}
	}
?>
</body>
</html>