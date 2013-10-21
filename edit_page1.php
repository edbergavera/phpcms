<?php # edit_page.php
// This page both displays and handles the "edit a page" form

// Need the utilities file:
require('includes/utilities.inc.php');

// Create a new form:
//set_include_path(get_include_path().PATH_SEPARATOR.'/usr/share/php/');
require('HTML/QuickForm2.php');

$select_query = 'SELECT id, creatorId FROM pages WHERE id=:id';
$stmt = $pdo->prepare($select_query);
$select_result = $stmt->execute(array(':id'=>$_GET['id']));

// If the query ran ok, fetch the record into an object:
if($select_result){
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Page');
    $page = $stmt->fetch();
}
if (!$user->canEditPage($page)) {
    header("Location:index.php");
    exit();
}


$form = new HTML_QuickForm2('editPageForm');
// Add the title field:
$title = $form->addElement('text', 'title');
$title->setLabel('Page Title');
$title->addFilter('strip_tags');
$title->addRule('required', 'Please enter a page title');

// Add the content field:
$content = $form->addElement('textarea', 'content');
$content->setLabel('Page Content');
$content->addFilter('trim');
$content->addRule('required', 'Please enter the page content.');

// Add the submit Button:
$submit = $form->addElement('submit', 'submit', array('value'=>'Edit This Page'));

// Add a hidden form element
$pid = $form->addElement('hidden', 'id');

// Run the select method on the page id
$select_query = 'SELECT id, creatorId, title, content, DATE_FORMAT(dateAdded, "%e %M %Y") AS dateAdded
FROM pages WHERE id=:id';
$stmt = $pdo->prepare($select_query);
$select_result = $stmt->execute(array(':id'=>$_GET['id']));

//if it ran ok, fetch the page as an object and set the retrieved values to the form
if($select_result){
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Page');
    while($page = $stmt->fetch()){

        $title->setValue($page->getTitle());
        $content->setValue($page->getContent());
        $pid->setValue($page->getId());
    }
}
// Check for a form submission:
if($_SERVER['REQUEST_METHOD'] == 'POST'){ //handle the form submission
    
    // Validate the form data:
    if($form->validate()){
        
        // Insert into the database:
        $insert_query = 'UPDATE pages SET title=:title, content=:content, dateUpdated=NOW() WHERE id=:id';
        $stmt = $pdo->prepare($insert_query);
        $insert_result = $stmt->execute(array
        (':id'=>$pid->getValue(),':title'=>$title->getValue(),':content'=>$content->getValue()));
        
        // Redirect the user to the newly edited page
        //if($insert_result){
        //    header("Location:page.php?id=".$pid->getValue());
       // }
    } // end of form validation IF
} // End of form submission IF

$pageTitle = 'Edit this Page';
include('includes/header.inc.php');
include('views/edit_page.html');
include('includes/footer.inc.php');

?>