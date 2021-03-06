<?php
if (isset($_POST['cmd'])) {
	$cmd = $_POST['cmd'];
	$cmd();
}
else {
	echo json_encode(['msg'=>'command not found','type'=>'error']);
	die();
}
function login() {
	require_once('db.php');
	session_start();
	if (isset($_POST['username'])) {
		$username = $_POST['username'];
	}
	else {
		echo json_encode(['msg'=>'username not found','type'=>'error']);
		die();		
	}                                                                                                                                                                         
	if (isset($_POST['password'])) {
		$password = $_POST['password'];
	}
	else {
		echo json_encode(['msg'=>'password not found','type'=>'error']);
		die();
	}

	$sql = "SELECT * FROM users WHERE username='{$username}' AND password='{$password}' LIMIT 1";
	$query = mysqli_query($conn,$sql);
	$data = mysqli_fetch_assoc($query);
	// echo json_encode($query);die();
	if ($data !== null) {
		$_SESSION['login_id'] = $data['id'];
		$_SESSION['login_username'] = $data['username'];
		echo json_encode($data);
	}
	else {
		echo json_encode(['msg'=>'wrong credentials','type'=>'error']);
	}

}

function get_contacts() {
	require_once('db.php');
	session_start();
	$id = $_SESSION['login_id'];
	if ($id != 0 && $id !== null) {
		$sql = "SELECT * FROM users WHERE id != $id";
		$query = mysqli_query($conn,$sql);
		$data = mysqli_fetch_all($query, MYSQLI_ASSOC);
		if ($data !== null) {
			echo json_encode($data);
		}
		else {
			echo json_encode(['msg'=>'No contacts found','type'=>'error']);
		}
	}
	else {
		echo json_encode(['msg'=>'Id not found','type'=>'error']);
	}
}

function get_chats() {
	require_once('db.php');
	session_start();
	$rid = $_SESSION['login_id'];
	$sid = isset($_POST['sid']) ? $_POST['sid'] : 0;
	if ($rid != 0 && $rid !== null) {
		$sql = "SELECT chats.message, users.username FROM chats INNER JOIN users ON chats.sender = users.id WHERE (receiver = $rid AND sender = $sid) OR (sender = $rid AND receiver = $sid)";
		$query = mysqli_query($conn,$sql);
		$data = mysqli_fetch_all($query, MYSQLI_ASSOC);
		if ($data !== null) {
			echo json_encode($data);
		}
		else {
			echo json_encode(['msg'=>'No contacts found','type'=>'error']);
		}
	}
	else {
		echo json_encode(['msg'=>'Id not found','type'=>'error']);
	}
}

function send_msg() {
	session_start();
	require_once('db.php');
	$sid = $_SESSION['login_id'] ? $_SESSION['login_id'] : 0;
	$rid = $_POST['rid'] ? $_POST['rid'] : 0;
	$msg = $_POST['msg'] ? $_POST['msg'] : 0;
	if ($sid > 0 && $rid > 0) {
		$sql = "INSERT INTO chats (receiver,message,sender,status) VALUES ($rid,'{$msg}',$sid,0)";
		$query = mysqli_query($conn, $sql);
		if (mysqli_affected_rows($conn) == 1) {
			echo json_encode(['msg'=>'Your message is saved','type'=>'success']);
		}
		else {
			echo json_encode(['msg'=>'Could not save your message','type'=>'error']);
		}
	}
	else {
		echo json_encode(['msg'=>'Id not found','type'=>'error']);
	}
}

function logout() {
	session_start();
	if (session_destroy()) {
		echo json_encode(['msg'=>'You have logged out!','type'=>'success']);
	}
	else {
		echo json_encode(['msg'=>'Try again!','type'=>'error']);
	}
}
?>