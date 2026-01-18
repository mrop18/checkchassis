<?php
$data = json_decode(file_get_contents('data.json'), true);
$data = array_reverse($data); // Show newest first

// Function to create a URL-safe slug from title
function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    return strtolower($text);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Check Chassis - Blogs</title>
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
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1335824760537566"
     crossorigin="anonymous"></script>
     <script async custom-element="amp-auto-ads"
        src="https://cdn.ampproject.org/v0/amp-auto-ads-0.1.js">
</script>
  <style>
    .bms{
        height: 100%;
        margin: 50px 100px 0px 100px;
    }
    h3{
      font-size: 20px;
      margin: 20px 0px;
    }

    .blog-card {
      border: 1px solid #ccc;
      margin-bottom: 20px;
      padding: 10px;
      display: flex;
      gap: 20px;
      cursor: pointer;
      transition: all 300ms ease;
      color: #01162e;
    }
    .blog-card:hover{
      color: #f4fefe;
      background-color: #01162eda;
      border-radius: 10px;
    }
    .blog-card img {
      width: 200px;
      height: 120px;
      object-fit: cover;
    }
    .blog-info h2 {
      margin: 0 0 10px;
    }
    .blog-info p {
      margin: 5px 0;
    }
    @media (max-width: 991px) {
        .blog-card{
            flex-direction: column;
        }
        .blog-card img {
          width: 100%;
          height: 200px;
          object-fit: cover;
        }
        
    }
    @media (max-width: 426px) {
        .bms{
            height: 100%;
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
    <div class="bms">
      <h1>The Check Chassis Blog</h1>
      <h3>Latest blogs</h3>
      <hr>
      <div id="blog-list">
        <?php foreach ($data as $index => $blog): ?>
          <?php $slug = slugify($blog['title']); ?>
<div class="blog-card" onclick="openBlog(<?php echo $index; ?>, '<?php echo $slug; ?>')">
            <img src="<?php echo $blog['image']; ?>" alt="<?php echo $blog['title']; ?>">
            <div class="blog-info">
              <h2><?php echo $blog['title']; ?></h2>
              <p><strong></strong> <?php echo $blog['type']; ?></p>
              <p><strong></strong> <?php echo $blog['readmore']; ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
  <script>
    function openBlog(index, slug) {
  const url = `/blog/${index}-${slug}`;
  window.location.href = url;
}
  </script>
</body>
</html>
