<?php
$blogs = json_decode(file_get_contents('data.json'), true);
$reversedBlogs = array_reverse($blogs);

// Function to slugify a title
function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    return strtolower($text);
}

// Validate ID
if (isset($_GET['id']) && isset($reversedBlogs[$_GET['id']])) {
    $blogId = $_GET['id'];
    $selectedBlog = $reversedBlogs[$blogId];
    
    // Check if slug is correct
    $correctSlug = slugify($selectedBlog['title']);
    $urlSlug = '';
    if (isset($_GET['title'])) {
        $urlSlug = $_GET['title'];
    } else {
        // Fallback for SEO URL like /blog/0-how-to-check-vin
        $parts = explode('-', $_SERVER['REQUEST_URI'], 2);
        if (isset($parts[1])) {
            $urlSlug = basename($parts[1]); // gets part after the dash
        }
    }

    if ($urlSlug !== $correctSlug) {
        // Redirect to correct slug
        header("Location: blog.php?id=$blogId&title=$correctSlug");
        exit;
    }
} else {
    echo "<p>Blog not found.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $selectedBlog['title']; ?> - Check Chassis</title>
    <meta name="description" content="<?php echo substr(strip_tags($selectedBlog['description']), 0, 160); ?>">
    <meta name="keywords" content="<?php echo isset($selectedBlog['keywords']) ? implode(', ', $selectedBlog['keywords']) : ''; ?>">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src='https://kit.fontawesome.com/f2e915867a.js' crossorigin='anonymous'></script>
  
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet">
      <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1335824760537566"
     crossorigin="anonymous"></script>
     <script async custom-element="amp-auto-ads"
        src="https://cdn.ampproject.org/v0/amp-auto-ads-0.1.js">
</script>
  <style>

    #blog-container{
      margin: 100px;
    }
  
    img {
      width: 100%;
      margin-bottom: 20px;
    }
    h1 {
      font-size: 32px;
      margin: 20px 0px;
      color: #01162e;
    }
    h2 {
      font-size: 16px;
      color: #01162e;
      margin-top: 30px;
    }
    p {
      line-height: 1.6;
      color: #01162e;
    }
    strong{
      font-weight: 500;
    }
    @media (max-width: 426px) {
        #blog-container{
            margin: 50px 10px 0px 10px;
        }
    }
  </style>
</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-7BY7SLP8W6"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-7BY7SLP8W6');
</script>
<body>
  <amp-auto-ads type="adsense"
        data-ad-client="ca-pub-1335824760537566">
</amp-auto-ads>
    <?php include 'components/_navbar.php' ?>

    <div id="blog-container">
    <h1><?php echo $selectedBlog['title']; ?></h1>
    <!-- <p><strong></strong> <?php echo $selectedBlog['type']; ?> | <strong>Date:</strong> <?php echo $selectedBlog['date']; ?></p> -->
    <img src="<?php echo $selectedBlog['image']; ?>" alt="<?php echo $selectedBlog['title']; ?>">
    <p><strong></strong> <?php echo $selectedBlog['description']; ?></p>

    <?php 
    $sections = isset($selectedBlog['sections']) ? $selectedBlog['sections'] : [];
    foreach ($sections as $section): 
    ?>
      <h2><?php echo $section['heading']; ?></h2>
      <p><?php echo $section['content']; ?></p>
    <?php endforeach; ?>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
</body>
</html>
