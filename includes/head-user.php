<?php include 'functions/init.php'; 

if(isset($_GET['username']) && !empty($_GET['username'])){
    $username    = $functions->checkInput($_GET['username']);
    $profileId   = $functions->userIdByUsername($username);
    $profileData = $functions->user_data($profileId);

    if(!$profileData) {
        echo("<script>location.href = '".BASE_URL."page404.html'</script>");
        exit();
    } else {
        $functions->addVisitor($profileId);
    }

} else {
    echo("<script>location.href = '".BASE_URL."'</script>");
    die();
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name='description' content='SocialsHub - website with social media of your friends, celebrities and other people.'>
    <meta name='keywords' content='social media, social link, social links, socialhub, social hub, socials hub, friends, celebrity, instagram, twitter, facebook, snapchat, twitch, tiktok, discord, mail, poland, website, bio, book for social media, book, book of social media, wikipedia, socialshub, wroclaw, profile visits, search, social media search, social link search, social links, links hub, social network, network links, one url'>
    <meta name='author' content='Krystian Czajkowski'>
    <link rel="icon" href="logo/logo-little.png">
    <title>SocialsHub. One Link to All Your Content</title>
    <link rel="shortcut icon" href="">
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-148899862-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-148899862-1');
    </script>

    <!-- Index and user's custom links font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    <!--  BOOTSTRAP include  -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!--  CSS include  -->
    <link rel="stylesheet" href="css/style.css">
    <!--  Lato font  -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700&amp;subset=latin-ext" rel="stylesheet">
    <!--  Font awsome  -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- OG -->
    <meta property="og:title" content="@<?php echo $profileData->screenName ?> | SocialsHub.net" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://www.socialshub.net" />
    <meta property="og:image" content="https://socialshub.net/<?php echo $profileData->profileImage?>" />
    <meta property="og:description" content="SocialsHub.net | All Your Content in One Link" />
</head>

