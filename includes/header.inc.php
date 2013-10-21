<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo (isset($pageTitle)) ? $pageTitle : 'Some Content Site'; ?></title>
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="js/custom-jquery.js"></script>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/fonts/fonts.css">
    <link rel="stylesheet" href="css/main.css">
    <!--[if lt IE 8]>
    <link rel="stylesheet" href="css/ie6-7.css">
    <![endif]-->
</head>
<!-- # header.inc.php - Script 9.1 -->
<body>
    <header>
        <h1>OOP Class<span>PHP object-Oriented Programming is FUN!</span></h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li><li><a href="archives.php">Archives</a></li><li><a href="contact.php">Contact</a></li><?php if ($user && $user->isAdmin()) echo '<li><a href="add_page.php">Add a New Page</a></li>'; ?><li><?php if ($user) { echo '<a href="logout.php">Logout</a>'; } else { echo '<a href="login.php">Login</a>'; } ?>
            </ul>
        </nav>
    </header>