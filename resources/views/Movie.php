<html>
<head>
    <title><?=$movie->getOriginalTitle();?></title>
</head>
<body>
    <h1><?=$movie->getOriginalTitle();?></h1>
    <img src="http://image.tmdb.org/t/p/w185<?=$movie->getPosterPath();?>" />
    <h4>Genres: <?=implode(', ', $movie->getGenres());?></h4>
    <h4>Overview: <?=$movie->getOverview();?></h4>
    <?php if ($movie->getReleaseDate()) :
        $movie->getReleaseDate()->format('F dS Y');
    else:
        $date = 'N/A';
    endif;
    ?>
    <h4>Release date: <?=$date?></h4>
</body>
</html>