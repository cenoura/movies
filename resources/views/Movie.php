<html>
<head>
    <title><?=$movie->getOriginalTitle();?></title>
</head>
<body>
    <h1><?=$movie->getOriginalTitle();?></h1>
    <img src="<?=$movie->getImageUrl();?>" />
    <h4>Genres: <?=$movie->getGenres();?></h4>
    <h4>Overview: <?=$movie->getOverview();?></h4>
    <h4>Release date: <?=$movie->getReleaseDate();?></h4>
</body>
</html>