<html>
<head>
    <title>Movies</title>
</head>
<body>
<h1>Movies</h1>
<form method="get">
    <input type="hidden" name="controller" value="movie" />
    <input type="hidden" name="action" value="search" />
    <input type="text" name="query" placeholder="Search movies..." />
</form>

<?php for ($i = 1; $i <= $result['totalPages']; $i++) :
    $url = './?controller=movie&action='.$action.'&page='.$i;
    if (isset($query)) {
        $url .= '&query=' . $query;
    }
    ?>
    <a href="<?=$url?>"><?=$i?></a>
<?php endfor; ?>
<br><br>
<table border="1">
    <?php foreach ($result['movies'] as $movie): ?>
    <tr>
        <td>
            <?php if ($movie->getPosterPath()) :
                $img = $movie->getPosterPath();
            else :
                $img = $movie->getBackdropPath();
            endif;
            ?>
            <img src="http://image.tmdb.org/t/p/w185<?=$img?>" />
        </td>
        <td>
            <h1><?=$movie->getOriginalTitle();?></h1>

            <h4>Genres: <?=implode(', ', $movie->getGenres());?></h4>
            <h4>Overview: <?=$movie->getOverview();?></h4>
            <?php if ($movie->getReleaseDate()):
                $releaseDate = $movie->getReleaseDate()->format('F dS Y');
            else:
                $releaseDate = 'N/A';
            endif;
            ?>
            <h4>Release date: <?=$releaseDate?></h4>
            <h4><a href="./?controller=movie&action=getOne&id=<?=$movie->getId();?>">Go to movie page</a></h4>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>