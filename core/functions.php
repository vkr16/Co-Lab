<?php
function isemailused($email)
{
    global $link;

    $email = mysqli_real_escape_string($link, $email);

    $query = "SELECT * FROM users WHERE email = '$email'";
    if ($result = mysqli_query($link, $query)) {
        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
}

function isusernametaken($username)
{
    global $link;

    $username = mysqli_real_escape_string($link, $username);

    $query = "SELECT * FROM users WHERE username = '$username'";
    if ($result = mysqli_query($link, $query)) {
        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
}

function isstudentidused($studentid)
{
    global $link;

    $studentid = mysqli_real_escape_string($link, $studentid);

    $query = "SELECT * FROM users WHERE studentid = '$studentid'";
    if ($result = mysqli_query($link, $query)) {
        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
}

function createaccount($fullname, $studentid, $username, $email, $password)
{
    global $link;

    $fullname = mysqli_real_escape_string($link, $fullname);
    $studentid = mysqli_real_escape_string($link, $studentid);
    $username = mysqli_real_escape_string($link, $username);
    $email = mysqli_real_escape_string($link, $email);
    $password = mysqli_real_escape_string($link, $password);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (fullname,studentid, username, email, password) VALUES ('$fullname','$studentid','$username','$email','$password')";

    if (mysqli_query($link, $query)) {
        return true;
    } else {
        return false;
    }
}

function isexist($useridentity)
{

    global $link;

    $useridentity = mysqli_real_escape_string($link, $useridentity);
    $query = "SELECT * FROM users WHERE username = '$useridentity' OR email = '$useridentity'";
    $result = mysqli_query($link, $query);
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function isvalid($useridentity, $password)
{
    global $link;

    $useridentity = mysqli_real_escape_string($link, $useridentity);
    $password = mysqli_real_escape_string($link, $password);

    $query = "SELECT * FROM users WHERE username = '$useridentity' OR email = '$useridentity'";
    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);
    $savedpassword = $data['password'];

    if (password_verify($password, $savedpassword)) {
        return true;
    } else {
        return false;
    }
}

function savesession($staylogin, $useridentity)
{
    global $link;

    $useridentity = mysqli_real_escape_string($link, $useridentity);

    $query = "SELECT * FROM users WHERE username = '$useridentity' OR email = '$useridentity'";
    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);

    $uniqueid = $data['uniqueid'];
    $username = $data['username'];
    $role     = $data['role'];
    $_SESSION['cl_user'] = $username;

    if ($staylogin == true) {
        setcookie('CL_Session', $uniqueid, time() + (86400), "/");
    }

    if ($role == "admin") {
        header("Location: admin/");
    } else {
        header("Location: user/");
    }
}

function isadmin($username)
{
    global $link;

    $username = mysqli_real_escape_string($link, $username);

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);

    $role = $data['role'];
    if ($role == 'admin') {
        return true;
    } else {
        return false;
    }
}

function autologin($uniqueid)
{
    global $link;

    $uniqueid = mysqli_real_escape_string($link, $uniqueid);

    $query = "SELECT * FROM users WHERE uniqueid = '$uniqueid'";
    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);

    $username = $data['username'];
    $_SESSION['cl_user'] = $username;
}

function getemailfromidentity($useridentity)
{

    global $link;

    $useridentity = mysqli_real_escape_string($link, $useridentity);

    $query = "SELECT * FROM users WHERE username = '$useridentity' OR email = '$useridentity'";
    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);

    $email = $data['email'];
    return $email;
}

function isuidmatch($email, $uid)
{
    global $link;
    $email = mysqli_real_escape_string($link, $email);
    $uid = mysqli_real_escape_string($link, $uid);

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);

    $uniqueid = $data['uniqueid'];

    if ($uid == $uniqueid) {
        return true;
    } else {
        return false;
    }
}

function resetpassword($email, $password)
{
    global $link;

    $email = mysqli_real_escape_string($link, $email);
    $password = mysqli_real_escape_string($link, $password);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE users SET password = '$password' WHERE email = '$email'";

    if (mysqli_query($link, $query)) {
        return true;
    } else {
        return false;
    }
}

function changeuniqueid($useridentity)
{
    global $link;

    $useridentity = mysqli_real_escape_string($link, $useridentity);
    $new_uniqueid =  bin2hex(random_bytes(20));

    $query = "UPDATE users SET uniqueid = '$new_uniqueid' WHERE username = '$useridentity' OR email = '$useridentity'";
    mysqli_query($link, $query);
    return $new_uniqueid;
}

function isactivated($useridentity)
{
    global $link;
    $useridentity = mysqli_real_escape_string($link, $useridentity);
    $query = "SELECT * FROM users WHERE username = '$useridentity' OR email = '$useridentity'";
    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);

    if ($data['validity'] == "valid") {
        return true;
    } else {
        return false;
    }
}
