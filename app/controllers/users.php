<?php
class users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }
    public function index($name = '')
    {
        echo "user pages";
    }
    public function signup()
    {
        require_once "../app/utils/functions.php";
        // check if request is post request
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $errors = [];
            // sanitize all post request from the form
            $firstname = htmlentities($_POST['firstname'], ENT_QUOTES, "utf-8");
            $lastname = htmlentities($_POST['lastname'], ENT_QUOTES, "utf-8");
            $email = htmlentities($_POST['email'], ENT_QUOTES, "utf-8");
            $password = htmlentities($_POST['password'], ENT_QUOTES, "utf-8");
            $confirm_password = htmlentities($_POST['confirm_password'], ENT_QUOTES, "utf-8");
            $gendor = htmlentities($_POST['gendor'], ENT_QUOTES, "utf-8");
            $pattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/';
            $image = 'https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png';

            // check if firstname empty
            if (empty($firstname)) {
                $errors[] = 'firstname is require!';
            }
            // if if firstname is less than 3 character
            if (!empty($firstname) && strlen($firstname) < 3) {
                $errors[] = 'firstname should be more than 3 character !';
            }
            // check if lastname empty
            if (empty($lastname)) {
                $errors[] = 'lastname is require!';
            }
            // check if lastname less than 3 chracter
            if (!empty($lastname) && strlen($lastname) < 3) {
                $errors[] = 'last$lastname should be more than 3 character !';
            }
            // check if email empty
            if (empty($email)) {
                $errors[] = 'email is require!';
            } else {
                // check if email is already exist in DB
                $user = $this->userModel->checkEmailExist($email);
                if ($user) {
                    $errors[] = 'email is already exist!';
                }
            }
            // check if email in the correct format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format";
            }
            // check if password is empty
            if (empty($password)) {
                $errors[] = 'password is require!';
            }
            // check if password match the regex pattern
            if (!preg_match($pattern, $password)) {
                $errors[] = "password must be min 8 characters, at least 1 number, at least one uppercase, at least one lowercase";
            }
            // check if password equal to confirm password
            if ($password != $confirm_password) {
                $errors[] = "confirm password must be same as password";
            }
            // check if gendor is empty
            if (empty($gendor)) {
                $errors[] = 'gendor is require!';
            }
            // check if upload dir is not exist
            if (!file_exists("../public/upload")) {
                mkdir("../public/upload");
            }
            // check if input filed is selected
            if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                $file_tmp = $_FILES['image']['tmp_name'];
                $file_type = $_FILES['image']['type'];
                $image = "../public/upload/" . random() . $file_name;
                $image = str_replace(' ', '_', $image);
                $extensions = array("jpg", "png");
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                // check if image extenstions is jpg or png
                if (in_array($ext, $extensions) === false) {
                    $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                }
                // check if file size is greater than 2MB
                if ($file_size > 2097152) {
                    $errors[] = 'File size must less than 2 MB';
                } else {
                    // upload the file to the server
                    move_uploaded_file($file_tmp, $image);
                }
            }
            // if there is no errors, processed 
            if (empty($errors)) {
                // register user
                $this->userModel->register($email, $firstname, $lastname, $gendor, $image, $gendor);
                session_start();
                $_SESSION['succuss'] = 'user ' . $firstname . " is succuessful singup to the page";
                $_SESSION["loggedin"] = true;
                $_SESSION["fullname"] = $firstname . " " . $lastname;
                $_SESSION["email"] = $email;
                $_SESSION["image"] = $image;
                session_write_close();
                header("Location: ../welcome");
                exit;
            } else {
                session_start();
                $_SESSION['errors'] = $errors;
                session_write_close();
                header("Location: signup");
            }
        } else {
            $this->view("signup");
        }
    }
    public function login()
    {
        // if request is post request
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            // redirect to welcome page
            header("Location: ../welcome");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $errors = [];
            // sanitize  email & password
            $email = htmlentities($_POST['email'], ENT_QUOTES, "utf-8");
            $password = htmlentities($_POST['password'], ENT_QUOTES, "utf-8");

            // check if email is empty
            if (empty($email)) {
                $errors[] = 'email is require!';
            }
            // check if password is empty
            if (empty($password)) {
                $errors[] = 'password is require!';
            }
            // if there is no error, processed 
            if (empty($errors)) {
                $user = $this->userModel->selectUserByEmail($email);
                // check if email exist
                if (password_verify($password, $user->password)) {
                    echo "verify";
                } else {
                    echo "not verify";
                }
                die();
                if (!($user)) {
                    session_start();
                    $errors[] = "email does not exist";
                    $_SESSION['errors'] = $errors;
                    session_write_close();
                    header("location: login");
                } else {
                    // verify password 
                    if (password_verify($password, $user->password)) {
                        session_start();
                        $_SESSION["loggedin"] = true;
                        $_SESSION["email"] = $email;
                        $_SESSION["fullname"] = $user->firstname . " " . $user->lastname;
                        $_SESSION['succuss'] = 'user ' . $user->firstname . " is succuessful login to the page";
                        $_SESSION["image"] = $user->photo;
                        session_write_close();
                        header("location: ../welcome");
                    } else {
                        session_start();
                        $errors[] = "password incorrect";
                        $_SESSION['errors'] = $errors;
                        session_write_close();
                        header("location: login");
                    }
                }
            } else {
                session_start();
                $_SESSION['errors'] = $errors;
                session_write_close();
                header("location: login");
            }
        } else {
            $this->view("login");
        }
    }
    public function logout()
    {
        session_start();

        $_SESSION = array();

        session_destroy();

        header("location: login");
        exit;
    }
}
