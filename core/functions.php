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

function createaccount($fullname, $username, $email, $password)
{
    global $link;

    $fullname = mysqli_real_escape_string($link, $fullname);
    $username = mysqli_real_escape_string($link, $username);
    $email = mysqli_real_escape_string($link, $email);
    $password = mysqli_real_escape_string($link, $password);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (fullname, username, email, password) VALUES ('$fullname','$username','$email','$password')";

    if (mysqli_query($link, $query)) {
        return true;
    } else {
        return false;
    }
}
