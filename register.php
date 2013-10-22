<?php # register.php - 9.11
// This page both displays and handles the login form.

// Need the utilities file:
require('includes/utilities.inc.php');

// Create a new form:
set_include_path(get_include_path() . PATH_SEPARATOR . '/usr/share/php/');
require('HTML/QuickForm2.php');
$form = new HTML_QuickForm2('registerForm');

$username = $form->addElement('text', 'username');
$username->setLabel('username');
$username->addFilter('trim');
$username->addRule('required', 'Please enter username');

// Add the email address:
$email = $form->addElement('text', 'email');
$email->setLabel('Email Address');
$email->addFilter('trim');
$email->addRule('required', 'Please enter your email address.');
$email->addRule('email', 'Please enter a valid email address');

// Add the password field:
$password = $form->addElement('password', 'pass');
$password->setLabel('Password');
$password->addFilter('trim');
$password->addRule('required', 'Please enter your password.');

$options = array(
    1 => 'public', 2 => 'author', 3 => 'admin'
);

$usertype = $form->addElement('select', 'usertype', null, array('options' => $options, 'label' => 'Privileges'));

// $userType = $form->addElement('fieldset')->setLabel('Privileges');
// $userType->addElement(
//     'radio', 'type', array('value' => 'public'), array('content' => 'Public User')
// );
// $userType->addElement(
//     'radio', 'type', array('value' => 'author'), array('content' => 'Author')
// );

// $userType->addElement(
//     'radio', 'type', array('value' => 'admin'), array('content' => 'Admin')
// );
// $userType->addRule('required', 'Please select privilige');

// Add the submit button:
$form->addElement('submit', 'submit', array('value'=>'Add User'));

// Check for a form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form submission
    
    // Validate the form data:
    if ($form->validate()) {
        
        // Check against the database:
        $q = 'INSERT INTO users (userType, username, email, pass, dateAdded) VALUES (:usertype, :username, :email, SHA1(:pass), NOW())';
        $stmt = $pdo->prepare($q);
        $r = $stmt->execute(array(':usertype' => $usertype->getValue(), ':username' => $username->getValue(), ':email' => $email->getValue(), ':pass' => $password->getValue()));
        // var_dump($userType->getValue());
        // Try to fetch the results:
        if ($r) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            $user = $stmt->fetch();
        }
        
        // // Store the user in the session and redirect:
        // if ($user) {
    
        //     // Store in a session:
        //     $_SESSION['user'] = $user;
    
        //     // Redirect:
        //     header("Location:index.php");
        //     exit;
    
        // }
        
    } // End of form validation IF.
    
} // End of form submission IF.

// Show the login page:
$pageTitle = 'Register User';
include('includes/header.inc.php');
include('views/register.html');
include('includes/footer.inc.php');
?>