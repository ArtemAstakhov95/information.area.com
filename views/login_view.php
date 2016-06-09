<?php
/**
 * Created by PhpStorm.
 * User:
 * Date: 19.12.2015
 * Time: 18:22
 */

class AuthClass{
    private $_login = "admin";
    private $_password = "qwerty";

    public function isAuth(){
        if(isset($_SESSION["is_auth"])){
            return $_SESSION["is_auth"];
        }
        else
            return false;
    }

    public function auth($login, $password){
        if($login == $this->_login && $password == $this->_password){
            $_SESSION["is_auth"] = true;
            $_SESSION["login"] = $login;
            return true;
        }
        else{
            $_SESSION["is_auth"] = false;
            return false;
        }
    }

    public function getLogin(){
        if($this->isAuth()){
            return $_SESSION["login"];
        }
    }

    public function out(){
        $_SESSION = array();
        session_destroy();
    }
}

$auth = new AuthClass();

if(isset($_GET['exit'])){
    if($_GET['exit'] == 1){
        $auth->out();
        echo '<script type="text/javascript">window.location.href="/"</script>';
    }
}

if(isset($_POST["login"]) && isset($_POST["pass"])){
    if(!$auth->auth($_POST["login"], $_POST["pass"])){

        echo "<H2>Ви ввели неправильні дані.</H2>";
        form();
        exit();
    }
    else{
        echo '<script type="text/javascript">window.location.href="/"</script>';
    }
}
else {
    form();
}

function form(){
    ?><div class="login-form">
        <form method='post' action="">
            <table>
                <tr>
                    <td>
                        <label for='login'>Login: </label>
                    </td>
                    <td>
                        <input type='text' name='login' value="<?= (isset($_POST['login'])) ? $_POST['login'] : null; ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for='pass'>Password: </label>
                    </td>
                    <td>
                        <input type='password' name='pass'>
                    </td>
                </tr>
            </table>
            <input type='submit' name='log' value='Увійти'>
        </form>
    </div><?
}
?>
<style>

</style>