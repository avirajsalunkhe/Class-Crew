<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "matoshree_db";

    // Establish connection
    $conn = mysqli_connect($host, $user, $pass, $db);
    
    // Check if 'username' and 'password' exist in $_POST before accessing them
    $username = isset($_POST['username']) ? $conn->real_escape_string($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (!empty($username) && !empty($password)) {
        // Use Prepared Statements for Security
        $query = "SELECT * FROM admins WHERE username = ? AND password = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            session_start();
            $_SESSION['avi'] = 'true';
            header("Location: 1stwin.php");
            exit;
        } else {
            echo '<script>alert("Incorrect ID/Password.");</script>';
        }
    } else {
        echo '<script>alert("Please enter both username and password.");</script>';
    }
}
?>

<html>
<head>
    <style>
*{
            margin: 0;padding: 0;box-sizing: border-box;
        }
        body{
            display: flex;
            align-items: center;
            flex-direction:column;
            width: 100vw;
            height:100vh;
            background: linear-gradient(to top,rgba(0, 0, 0, 0.5)50%,rgba(0, 0, 0, 0.5)50%),url(img2.jpg);
            background-position: center;
         background-size: cover;
         position: relative;

        }
        .main{
            background-color:rgb(102, 102, 102);
            border-radius: 10px;
            box-shadow: 10px 10px 8px rgba(0,0,0,0.5);

        }
        .form{
            width: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding:  20px 25px;
        
        }
        input{
            width: 100%;
            margin: 10px;
            color:rgb(255, 255, 255);
        }
        .heading{
            color: white;
            font-size: 30px;
            font-family:  ;
        }
        .main_heading{  
            margin-top:100px;
            margin-bottom:50px;
            color:rgb(255, 255, 255);
        }
        .main_heading span{
            color:rgb(0, 0, 0);
        }  

        
.input-group-login
{
	top: 150px;
	position:absolute;
	width:280px;
	transition:.5s;
}
.input-group-register
{
    top: 120px;
	position:absolute;
	width:280px;
	transition:.5s;
}
.input-field
{
	width: 100%;
	padding:10px 0;
	margin:5px 0;
	border-left:0;
	border-top:0;
	border-right:0;
	border-bottom: 1px solid rgba(255, 255, 255, 0.993);
	outline:none;
    background: transparent;
}
.submit-btn{
    background-color: rgb(146, 143, 143);
    color: rgb(5, 5, 5);
    width: 100%;
    font-size: 20px;
    font-style: bold;
    border-radius: 50px;
    padding: 10px 10px;
}
.register{
    color: #ddd;
}
.reg{
    color: black;
}
</style>
</head>
<body >
<h1 class="main_heading">Matoshree <span>Coaching </span>Classes</h1>

<div class="main">
        <div class="form">
            <div class="top">
                <div class="heading">
                    <span>Admin Login</span>
                </div>
            </div>
            <div class="bottom">
                    <form id='login' class='form'action=''method='post'>
                        <input type='text'name="username"class='input-field'placeholder='Email Id' required >
                        <input type='password'name="password"class='input-field'placeholder='Enter Password' required>
                        <br> <br>
                        <button type='submit'name='subtn'class='submit-btn'>Log in</button>
                        <br>
                        <span class="register">Don't have an account ? <a href="#" class="reg">Register</a></span>
                 </form>
                </form>
            </div>
        </div>
    </div>
</body>
</html>