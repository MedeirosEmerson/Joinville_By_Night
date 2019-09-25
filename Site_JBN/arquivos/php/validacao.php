<?php

session_start();

if (isset($_POST['acao'])) {
	if ($_POST['acao'] == 'Entrar') {
		validaUsuario();
	}
}

function validaUsuario() {
	
	include 'conexao.php';

	$email = filter_input(INPUT_POST, 'lbl_email', FILTER_SANITIZE_STRING);
	$senha = filter_input(INPUT_POST, 'lbl_password', FILTER_SANITIZE_STRING);

	$sql_comun = "SELECT * FROM tb_cliente WHERE email_cliente = '$email' LIMIT 1";

	$sql_admin = "SELECT * FROM tb_admin WHERE email_admin = '$email' LIMIT 1";

	$query_comun = mysqli_query($conexao,$sql_comun);
	$query_admin = mysqli_query($conexao,$sql_admin);

	$numRowsComum = $query_comun->num_rows;
	$numRowsAdm = $query_admin->num_rows;

	if ($numRowsComum != 0) {

		$row_user = mysqli_fetch_array($query_comun);
		if (password_verify($senha, $row_user['senha'])) {
			$_SESSION['usuarioID'] = $row_user['id_cliente']; 
			$_SESSION['usuarioNome'] = $row_user['nome_cliente']; 
			$_SESSION['usuarioNivel'] = $row_user['nivel'];
			header("Location:../../pags/index.php");
		}else {
			$_SESSION['msgErro'] = '<script>alert("E-Mail ou Senha incorretos.")</script>';
			header("Location: ../../index.php");
		}


	} elseif ($numRowsAdm != 0) {
		$row_user = mysqli_fetch_array($query_admin);
		if (password_verify($senha, $row_user['senha_admin'])) {
			$_SESSION['usuarioID'] = $row_user['id_admin']; 
			$_SESSION['usuarioNome'] = $row_user['nome_admin']; 
			$_SESSION['usuarioNivel'] = $row_user['nivel'];
			header("Location:../../pags/index.php");
		} else {
			$_SESSION['msgErro'] = '<script>alert("E-Mail ou Senha incorretos.")</script>';
			header("Location: ../../index.php");
		}
	} elseif ($numRowsComum == 0 || $numRowsAdm == 0) {
		$_SESSION['msgErro'] = '<script>alert("E-Mail não Cadastrado")</script>';
		header("Location: ../../index.php");
	}
}

?>