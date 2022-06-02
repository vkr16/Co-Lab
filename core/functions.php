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

function truncate($text, $chars = 40)
{
    if (strlen($text) <= $chars) {
        return $text;
    }
    $text = $text . " ";
    $text = substr($text, 0, $chars);
    $text = substr($text, 0, strrpos($text, ' '));
    $text = $text . "...";
    return $text;
}

function updateEmail($email, $username)
{
    global $link;

    $email = mysqli_real_escape_string($link, $email);
    $username = mysqli_real_escape_string($link, $username);

    $query = "UPDATE users SET email = '$email' WHERE username = '$username'";

    if (mysqli_query($link, $query)) {
        return true;
    } else {
        return false;
    }
}

function updatePass($username, $password)
{
    global $link;

    $username = mysqli_real_escape_string($link, $username);
    $password = mysqli_real_escape_string($link, $password);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE users SET password = '$password' WHERE username = '$username'";

    if (mysqli_query($link, $query)) {
        return true;
    } else {
        return false;
    }
}

function openTicket($user_id, $room_id, $time_start, $time_end, $notes)
{
    global $link;

    $user_id = mysqli_real_escape_string($link, $user_id);
    $room_id = mysqli_real_escape_string($link, $room_id);
    $notes = mysqli_real_escape_string($link, $notes);

    $query = "INSERT INTO tickets (user_id, room_id,time_start,time_end,notes) VALUES ('$user_id','$room_id','$time_start','$time_end','$notes')";
    if (mysqli_query($link, $query)) {
        return true;
    } else {
        return false;
    }
}

function getUserDataBySession()
{
    global $link;

    $username = $_SESSION['cl_user'];

    $username = mysqli_real_escape_string($link, $username);
    $query = "SELECT * FROM users WHERE username = '$username'";

    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);

    return $data;
}

function getRoomDataById($room_id)
{
    global $link;

    $room_id = mysqli_real_escape_string($link, $room_id);

    $query = "SELECT * FROM rooms WHERE id = '$room_id'";

    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);

    return $data;
}

function getAreaDataById($area_id)
{
    global $link;

    $area_id = mysqli_real_escape_string($link, $area_id);

    $query = "SELECT * FROM areas WHERE id = '$area_id'";

    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);

    return $data;
}

function isNowAvailable($room_id)
{
    global $link;
    $room_id = mysqli_real_escape_string($link, $room_id);
    $now = date("Y-m-d H:i:s");


    $query = "SELECT * FROM tickets WHERE time_start < '$now' AND time_end > '$now' AND room_id = $room_id";
    $result = mysqli_query($link, $query);

    $count = mysqli_num_rows($result);
    if ($count == 0) {
        return true;
    } else {
        return false;
    }
}

function isConflict($room_id, $start_time, $end_time)
{
    global $link;

    $room_id = mysqli_real_escape_string($link, $room_id);


    $query = "SELECT * FROM tickets WHERE room_id = '$room_id'";
    $result = mysqli_query($link, $query);

    while ($data = mysqli_fetch_assoc($result)) {
        $conflict = false;
        if ($start_time > $data['time_start'] && $start_time < $data['time_end']) {
            $conflict = true;
            break;
        } elseif ($end_time > $data['time_start'] && $end_time < $data['time_end']) {
            $conflict = true;
            break;
        } elseif (($start_time < $data['time_start'] && $start_time < $data['time_end']) && ($end_time > $data['time_start'] && $end_time > $data['time_end'])) {
            $conflict = true;
            break;
        } else {
            $conflict = false;
        }
    }


    if ($conflict == true) {
        return true;
    } else {
        return false;
    }
}

function getUserIdByUsername($username)
{

    global $link;

    $username = mysqli_real_escape_string($link, $username);

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($link, $query);
    $data = mysqli_fetch_assoc($result);

    $userid = $data['id'];
    return $userid;
}

function isPast($startDateTime)
{
    $now = date("Y-m-d H:i:s");
    $now_tolerated = date('Y-m-d H:i:s', strtotime($now . ' - 9 Minutes'));


    if ($startDateTime < $now_tolerated) {
        return true;
    } else {
        return false;
    }
}

function updateUsername($newUsername, $oldUsername)
{
    global $link;

    $newUsername = mysqli_real_escape_string($link, $newUsername);
    $oldUsername = mysqli_real_escape_string($link, $oldUsername);

    $query = "UPDATE users SET username = '$newUsername' WHERE username = '$oldUsername'";

    if (mysqli_query($link, $query)) {
        $_SESSION['cl_user'] = $newUsername;
        return true;
    } else {
        return false;
    }
}

function isSpaceConflict($space_no, $area_id, $start_time, $end_time)
{
    global $link;
    $query = "SELECT * FROM space_tickets WHERE area_id = '$area_id' AND space_no = '$space_no'";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) == 0) {
        $conflict = false;
    }

    while ($data = mysqli_fetch_assoc($result)) {
        $conflict = false;
        if ($start_time >= $data['time_start'] && $start_time <= $data['time_end']) {
            $conflict = true;
            break;
        } elseif ($end_time >= $data['time_start'] && $end_time <= $data['time_end']) {
            $conflict = true;
            break;
        } elseif (($start_time <= $data['time_start'] && $start_time <= $data['time_end']) && ($end_time >= $data['time_start'] && $end_time >= $data['time_end'])) {
            $conflict = true;
            break;
        } elseif (($start_time <= $data['time_start'] && $start_time <= $data['time_end']) && ($end_time >= $data['time_start'] && $end_time <= $data['time_end'])) {
            $conflict = true;
            break;
        } else {
            $conflict = false;
        }
    }

    if ($conflict == true) {
        return true;
    } else {
        return false;
    }
}
