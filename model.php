<?php










//if($_POST['submit']) {
//    $member_username = "admin";
//    $member_password = "admin";
//
//    $username = $_POST['username'];
//    $username = strtolower($username);
//    $password = $_POST['password'];
//
//    if ($username == $member_username && $password == $member_password) {
//        $_SESSION['username'] = $username;
//        header('Location: index.php');
//    } else {
//        echo "Incorrect : Username or Password";
//    }
//}
//
//session_start();
//
//if (isset($_SESSION['username'])) {
//    $username = $_SESSION['username'];
//} else {
//    header('Location: index.php?page=login');
//}







function make_connection()  {
    $mysqli = new mysqli('localhost','root','','myband_db');
    if ($mysqli->connect_errno) {
        die('Connection error ' . $mysqli->connect_errno . '<br>');
    }
    return $mysqli;
}

function get_articles() {

    $mysqli = make_connection();

    $query = "SELECT article, title, content, imagelink FROM articles ORDER BY article DESC";
    $stmt = $mysqli->prepare($query) or die ("error preparing 1");
    $stmt->bind_result($id,$title,$content,$imagelink) or die ('eoor binding result one');
    $stmt->execute() or die ('error executing');
    $results = array();
    while ($stmt->fetch()) {
        $article = array();
        $article[] = $id;
        $article[] = $title;
        $article[] = $content;
        $article[] = $imagelink;
        $results[] = $article;
    }
    return $results;
}
//    $mysqli = make_connection();
//    $query = "SELECT title FROM articles";
//    $stmt = $mysqli->prepare($query) or die ('Error Preparing 1.');
//    $stmt->bind_result($title) or die ('Error binding 1.');
//    $stmt->execute() or die ('Error executing 1.');
//    $results = array();
//    while ($stmt->fetch()) {
//        $results[] = $title;
//    }
//    return $results;
//
//}

function get_some_articles(){

    global $pageno, $searchterm;
    $mysqli = make_connection();
    $firstrow = ($pageno - 1) * ARTICLES_PER_PAGE;
    $per_page = ARTICLES_PER_PAGE;

    $query =   "SELECT title, content, imagelink ";
    $query .=  "FROM articles ";
    $query .=  "WHERE title LIKE ? OR ";
    $query .=  "content LIKE ? ";
    $query .=  "ORDER BY article ";
    $query .=  "DESC LIMIT $firstrow,$per_page";



    $stmt = $mysqli->prepare($query) or die ('Error Preparing 5.');
    $stmt->bind_param('ss',$searchterm,$searchterm) or die ('Error binding Search Term');
    $stmt->bind_result($title, $content, $imagelink) or die ('Error binding 1.');
    $stmt->execute() or die ('Error executing 1.');
    $results = array();
    while ($stmt->fetch()) {
        $article = array();
        $article[] = $title;
        $article[] = $content;
        $article[] = $imagelink;
        $results[] = $article;
    }
    return $results;
}

function calculate_pages() {

    $mysqli = make_connection();
    $query = "SELECT * FROM articles";
    $result = $mysqli->query($query) or die ('Error Querying2');
    $rows = $result->num_rows;
//    echo $rows;
    $number_of_pages = ceil($rows / ARTICLES_PER_PAGE);
    return $number_of_pages;
}

function get_number_of_pages(){
    $number_of_pages = calculate_pages() or die ('Error calculating');
    return $number_of_pages;
}




function verify_login()
{
    global $_SESSION;
    $username = $_POST['username_log'];
    $password = $_POST['password'];
    if ($username == 'admin' && $password == 'admin') {
        $_SESSION['logged_in'] = 'logged_in';
        ?>
        <html>
        <body>
        <p style="margin-top: 5%; background-color: rgba(0,255,20,0.35); font-size: 125%; text-align: center">You are now logged in, welcome!</p>
        <p style="margin-top: 1%; background-color: rgba(0,255,20,0.35); font-size: 125%; text-align: center">Click <a href="index.php?page=post">here </a>to make changes, upload or delete posts. </p>

        </body>
        </html>
<?php
        header('Location: index.php');

    } else {

        ?>
        <html>
        <body>
        <p style="margin-top: 5%; background-color: rgba(255,0,29,0.35); font-size: 125%; text-align: center">Password or Username incorrect, please try again.</p>
        </body>
        </html>
        
        <?php
    }
}

function save_changes()
{
    global $_SESSION;

    if (isset($_POST['Submit1'])) {

        ?>
        <html>
        <body>
        <p style="margin-top: 5%; background-color: green; font-size: 125%; text-align: center">Changes Saved!</p>
        </body>
        </html>
        <?php
    } else {
    }
}

function delete(){
    $id = $_GET['id'];

    $mysqli = make_connection();
    $query = "DELETE FROM articles WHERE article = ?";
    $stmt = $mysqli->prepare($query) or die ('demo error u know the one');
    $stmt-> bind_param('s', $id) or die ('Error binding demo');
    $stmt->execute() or die ('Error executing demo');
    header('Location: index.php?page=cms');

}




function upload() {
    $temp_location = $_FILES['image']['tmp_name'];
    $target_location = 'images/db-images/' . time() . $_FILES['image']['name'];

    move_uploaded_file($temp_location, $target_location);

    $title = $_POST['title'];
    $content = $_POST['content'];

    $mysqli = make_connection();
    $query = "INSERT INTO articles VALUES (0,?,?,?)";
    $stmt = $mysqli->prepare($query) or die ('error preparing 110');
    $stmt->bind_param('sss',$title,$content,$target_location) or die ('Error binding params');
    $stmt->execute() or die ('Error executing 110');
    $stmt->close();

    header('Location: index.php?page=cms');
}



