<?php
include "cartfuncties.php";
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Artikelpagina (geef ?id=.. mee)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<?php
    //?id=1 handmatig meegeven via de URL (gebeurt normaal gesproken als je via overzicht op artikelpagina terechtkomt)
    if (isset($_GET["id"])) {
        $stockItemID = $_GET["id"];
    } else {
        $stockItemID = 0;
    }
?>
<h1>Product <?php print($stockItemID) ?></h1>

<!-- dit bestand bevat alle code voor de pagina die één product laat zien -->
<?php
include __DIR__ . "/header.php";

$Query = "
       SELECT SI.StockItemID, SI.StockItemName, SI.MarketingComments, TaxRate, RecommendedRetailPrice,
       ROUND(SI.TaxRate * SI.RecommendedRetailPrice / 100 + SI.RecommendedRetailPrice,2) as SellPrice,
       QuantityOnHand,
       (SELECT ImagePath FROM stockitemimages WHERE StockItemID = SI.StockItemID LIMIT 1) as ImagePath,
       (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath
       FROM stockitems SI
       JOIN stockitemholdings SIH USING(stockitemid)
       JOIN stockitemstockgroups USING(StockItemID)
       JOIN stockgroups ON stockitemstockgroups.StockGroupID = stockgroups.StockGroupID
       WHERE 'iii' NOT IN (SELECT StockGroupID from stockitemstockgroups WHERE StockItemID = SI.StockItemID)
       GROUP BY StockItemID";

$Statement = mysqli_prepare($databaseConnection, $Query);
mysqli_stmt_execute($Statement);
$ReturnableResult = mysqli_stmt_get_result($Statement);
$ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);




    
$StockItem = getStockItem($_GET['id'], $databaseConnection);
$StockItemImage = getStockItemImage($_GET['id'], $databaseConnection);

?>
<div id="CenteredContent">
    <?php
    if ($StockItem != null) {
        ?>
        <?php
        if (isset($StockItem['Video'])) {
            ?>
            <div id="VideoFrame">
                <?php print $StockItem['Video']; ?>
            </div>
        <?php }
        ?>


        <div id="ArticleHeader">
            <?php
            if (isset($StockItemImage)) {
                // één plaatje laten zien
                if (count($StockItemImage) == 1) {
                    debug_to_console("wtf");
                    if(strtolower($StockItemImage[0]['ImagePath']) == 'chocolate.jpg' OR strtolower($StockItemImage[0]['ImagePath']) == 'toys.jpg'){
                         ?><div id="ImageFrame"
                         style="background-image: url('public/stockgroupimg/<?php print strtolower($StockItemImage[0]['ImagePath']); ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>
                        <?php
                    }else{ 
                    ?>
                    <div id="ImageFrame"
                         style="background-image: url('public/stockitemimg/<?php print strtolower($StockItemImage[0]['ImagePath']); ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>
                    <?php
                       }
                } else if (count($StockItemImage) >= 2) { ?>
                    <!-- meerdere plaatjes laten zien -->
                    <div id="ImageFrame">
                        <div id="ImageCarousel" class="carousel slide" data-interval="false">
                            <!-- Indicators -->
                            <ul class="carousel-indicators">
                                <?php for ($i = 0; $i < count($StockItemImage); $i++) {
                                    ?>
                                    <li data-target="#ImageCarousel"
                                        data-slide-to="<?php print $i ?>" <?php print (($i == 0) ? 'class="active"' : ''); ?>></li>
                                    <?php
                                } ?>
                            </ul>

                            <!-- slideshow -->
                            <div class="carousel-inner">
                                <?php for ($i = 0; $i < count($StockItemImage); $i++) {
                                    ?>
                                    <div class="carousel-item <?php print ($i == 0) ? 'active' : ''; ?>">
                                        <?php
                                        debug_to_console("test: ".strtolower($StockItemImage[$i]['ImagePath']));
                                        if(strtolower($StockItemImage[$i]['ImagePath']) == "" OR strtolower($StockItemImage[$i]['ImagePath']) == null){
                                            print('<img src="public/stockitemimg/'.strtolower($StockItemImage[$i]["BackupImagePath"]).'"">"');
                                        }else{
                                            print('<img src="public/stockitemimg/'.strtolower($StockItemImage[$i]["ImagePath"]).'"">"');
                                            print('<a class="carousel-control-next" href="public/stockitemimg/'.strtolower($StockItemImage[$i]["ImagePath"]).'" data-slide="next" style="
                                                    left: 50%;
                                                    top: 0px;
                                                    transform: rotate(270deg);
                                                    bottom: 80%;
                                                ">
                                                    <span class="carousel-control-enlarge-icon"></span>
                                                </a>');
                                            }
                                        ?>
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- knoppen 'vorige' en 'volgende' -->
                            <a class="carousel-control-prev" href="#ImageCarousel" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a class="carousel-control-next" href="#ImageCarousel" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </a>
                            
                        </div>
                    </div>
                    <?php
                }
            } else {debug_to_console("wtf2");
                ?>
                <div id="ImageFrame"
                     style="background-image: url('public/stockgroupimg/<?php print strtolower($StockItem['BackupImagePath']); ?>'); background-size: cover;"></div>
                <?php } ?>
            <h1 class="StockItemID">Artikelnummer: <?php print $StockItem["StockItemID"]; ?></h1>
            <h2 class="StockItemNameViewSize StockItemName">
                <?php print $StockItem['StockItemName']; ?>
            </h2>
            <div class="QuantityText" style="color: black";><?php print $StockItem['QuantityOnHand']; ?></div>
            <div id="StockItemHeaderLeft">
                <div class="CenterPriceLeft">
                    <div class="CenterPriceLeftChild">
                        <?php
                        if (isset($ReturnableResult) && count($ReturnableResult) > 0) {
                            foreach ($ReturnableResult as $row) {
                                if ($StockItem["StockItemID"] == $row["StockItemID"]) {
                                    print("<p class='StockItemPriceText'><b>€". sprintf('%0.2f', berekenVerkoopPrijs($row['RecommendedRetailPrice'], $row['TaxRate']))."</b></p>"); 
                                }
                            }
                        }
                        ?>
                        <h6 style="color: black" ;=""> Inclusief BTW </h6>
                        <!--<button class="ToevoegenWinkelmandbutton ToevoegenWinkelmandbutton1">Toevoegen Winkelmand</button>
                         formulier via POST en niet GET om te zorgen dat refresh van pagina niet het artikel onbedoeld toevoegt-->
                        <form method="post">
                            <input type="number" name="stockItemID" value="<?php print($stockItemID) ?>" hidden>

                            <input class="ToevoegenWinkelmandbutton ToevoegenWinkelmandbutton1" type="submit" name="submit" value="Toevoegen winkelmand">
                        </form>


                        
                        <?php
                            if (isset($_POST["submit"])) {              // zelfafhandelend formulier
                                $stockItemID = $_POST["stockItemID"];
                                addProductToCart($stockItemID);         // maak gebruik van geïmporteerde functie uit cartfuncties.php
                                
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div id="StockItemDescription">
            <h3>Artikel beschrijving</h3>
            <p><?php print $StockItem['SearchDetails']; ?></p>
        </div>
        <div id="StockItemSpecifications">
            <h3>Artikel specificaties</h3>
            <?php
            $CustomFields = json_decode($StockItem['CustomFields'], true);
            if (is_array($CustomFields)) { ?>
                <table>
                <thead>
                <th>Naam</th>
                <th>Data</th>
                </thead>
                <?php
                foreach ($CustomFields as $SpecName => $SpecText) { ?>
                    <tr>
                        <td>
                            <?php print $SpecName; ?>
                        </td>
                        <td>
                            <?php
                            if (is_array($SpecText)) {
                                foreach ($SpecText as $SubText) {
                                    print $SubText . " ";
                                }
                            } else {
                                print $SpecText;
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                </table><?php
            } else { ?>

                <p><?php print $StockItem['CustomFields']; ?>.</p>
                <?php
            }
            ?>
        </div>
        <?php
    } else {
        ?><h2 id="ProductNotFound">Het opgevraagde product is niet gevonden.</h2><?php
    } ?>
</div>

<div>
    <br> <h2 style="color:black;top:650px;left:310px;position:absolute;"> Reviews</h2> <br>
</div>



    <html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <div class="center">
        <div class="stars">
            <input type="radio" id="five" name="rate" value="5">
            <label for="five"></label>
            <input type="radio" id="four" name="rate" value="4">
            <label for="four"></label>
            <input type="radio" id="three" name="rate" value="3">
            <label for="three"></label>
            <input type="radio" id="two" name="rate" value="2">
            <label for="two"></label>
            <input type="radio" id="one" name="rate" value="1">
            <label for="one"></label>
            <span class="result"></span>
        </div>
    </div>
    </body>
    </html>

<!--<form action="view.php" method="post">-->
<!--Name: <input type="text" name="name"><br>-->
<!--    <textarea type="text" class="input" placeholder="Schrijf een review"></textarea><br>-->
<!--    <input type="submit" value="Plaats review">-->
<!--</form>-->     /* dit was om te testen naar de database. Om een input te sturen */-->


    <section id="app">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="comment">
                        <p v-for="items in item" v-text="items"></p>
                    </div><!--End Comment-->
                </div><!--End col -->
            </div><!-- End row -->
            <div class="row">
                <div class="col-6">
                    <textarea type="text" class="input" placeholder="Schrijf een review"  v-model="newItem" @keyup.enter="addItem()"></textarea>
                    <button v-on:click="addItem()" class='primaryContained' type="submit">Plaats review</button>
                </div><!-- End col -->
            </div><!--End Row -->
        </div><!--End Container -->
    </section><!-- end App -->


</body>
</html>






<?php
$ReviewName = postReviewName($_POST['Naam'], $databaseConnection);

if(isset($_POST['submit']))
{
//    $Naam = $_POST['Naam'];


    $insert = mysqli_query($Statement,"INSERT INTO `stockItems`(Naam) VALUES($Naam)");

    if(!$insert)
    {
        echo mysqli_error();

    }
    else
    {
        echo "Review added succesfully";
    }

    mysqli_close($Statement);

}
//
//
//function Review($Naam, $databaseConnection)
//{
//        $query = "INSERT INTO stockitems (Naam)
//                VALUES ('".$Naam."')";
//        $statement = mysqli_prepare($databaseConnection, $query);
//        mysqli_stmt_execute($statement);
//        print($query);
//    }
//if(isset($_POST['Naam'])) {
//                    Review($_POST['Naam'], $databaseConnection);
//                }
?>

<!--<html>-->
<!--<body>-->
<!---->
<!--<form action="view.php" method="POST">-->
<!--    <h2 style="color:black">Full Name:</h2>-->
<!--    <input type="text" name="Naam" placeholder="Enter Full Name" Required>-->
<!--    <br/>-->
<!--    <input type="submit" name="submit" value="Submit">-->
<!--</form>-->
<!---->
<!--</body>-->
<!--</html>-->