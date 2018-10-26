/* ------------------- BEGIN FORUMVINE LOGIN PATCH ------------------ */
error_log("There's a login, user: " . $username);
// should we try a tapatalk login?
$username_clean = utf8_clean_string($username);
$sql = 'SELECT * FROM ' . USERS_TABLE . " WHERE username_clean = '" . $this->db->sql_escape($username_clean) . "' AND import_status=1";
$result = $this->db->sql_query($sql);
$row = $this->db->sql_fetchrow($result);
$this->db->sql_freeresult($result);

if ($row) {
    error_log("Need to try tapatalk login");
    // need to try tapatalk login!
    include_once(__DIR__."/../../../tapatalk/login.php");
    $ttLoginResult = checkTapatalkLogin($username, $password);
    if ($ttLoginResult) {
        error_log("Tapatalk login correct!");
        // password is correct! update the db accordingly

        // update the db
        $sql = 'UPDATE ' . USERS_TABLE . " SET import_status=2, user_password='" . $this->db->sql_escape(phpbb_hash($password)) . "', tt_username='" . $this->db->sql_escape($username) . "', tt_password='" . $this->db->sql_escape($password) . "' WHERE user_id = '" . $row['user_id'] . "'";
        $this->db->sql_query($sql);
        error_log("Updated DB!");
    } else {
        error_log("Tapatalk login failed");
        return array(
            'status'		=> LOGIN_ERROR_PASSWORD,
            'error_msg'		=> 'LOGIN_ERROR_PASSWORD',
            'user_row'		=> $row,
        );
    }
}
/* ------------------- BEGIN FORUMVINE LOGIN PATCH ------------------ */
