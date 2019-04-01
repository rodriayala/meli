<?php
session_start();
require 'Meli/meli.php';
require 'configApp.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>


<div class="row">
                <div class="col-md-6">
                    <h3>Publish an Item</h3>
                    <p>
                        This is a example of how to list an item in <b>MLA</b> 
                       <br /> <b>You need to be authenticated to make it work.</b>
                       <br /> To be able to list an item in another country, <a href="https://github.com/mercadolibre/php-sdk/blob/master/examples/example_list_item.php">please update this file</a>, with values according to the site Id where your app works, like <b>category_id</b> and <b>currency</b>.
                     <br />
                    </p>
                    <pre class="pre-item">
"title" => "Item De Teste - Por Favor, Não Ofertar! --kc:off",
        "category_id" => "MLB1227",
        "price" => 10,
        "currency_id" => "ARS",
        "available_quantity" => 1,
        "buying_mode" => "buy_it_now",
        "listing_type_id" => "bronze",
        "condition" => "new",
        "description" => "Item de Teste. Mercado Livre's PHP SDK.",
        "video_id" => "RXWn6kftTHY",
        "warranty" => "12 month",
        "pictures" => array(
            array(
                "source" => "https://upload.wikimedia.org/wikipedia/commons/f/fd/Ray_Ban_Original_Wayfarer.jpg"
            ),
            array(
                "source" => "https://upload.wikimedia.org/wikipedia/commons/a/ab/Teashades.gif"
            )
        )
    )
                    </pre>

                    <?php
                    $meli = new Meli($appId, $secretKey);

                    if($_GET['code'] && $_GET['publish_item']) {

                        // If the code was in get parameter we authorize
                        $user = $meli->authorize($_GET['code'], $redirectURI);

                        // Now we create the sessions with the authenticated user
                        $_SESSION['access_token'] = $user['body']->access_token;
                        $_SESSION['expires_in'] = $user['body']->expires_in;
                        $_SESSION['refresh_token'] = $user['body']->refresh_token;

                        // We can check if the access token in invalid checking the time
                        if($_SESSION['expires_in'] + time() + 1 < time()) {
                            try {
                                print_r($meli->refreshAccessToken());
                            } catch (Exception $e) {
                                echo "Exception: ",  $e->getMessage(), "\n";
                            }
                        }

                        // We construct the item to POST
                        $item = array(
                            "title" => "Item De Teste - Por Favor, Não Ofertar! --kc:off",
        "category_id" => "MLB1227",
        "price" => 10,
        "currency_id" => "BRL",
        "available_quantity" => 1,
        "buying_mode" => "buy_it_now",
        "listing_type_id" => "bronze",
        "condition" => "new",
        "description" => "Item de Teste. Mercado Livre's PHP SDK.",
        "video_id" => "RXWn6kftTHY",
        "warranty" => "12 month",
        "pictures" => array(
            array(
                "source" => "https://upload.wikimedia.org/wikipedia/commons/f/fd/Ray_Ban_Original_Wayfarer.jpg"
            ),
            array(
                "source" => "https://upload.wikimedia.org/wikipedia/commons/a/ab/Teashades.gif"
            )
        )
    );
                        
                        $response = $meli->post('/items', $item, array('access_token' => $_SESSION['access_token']));

                        // We call the post request to list a item
                        echo "<h4>Response</h4>";
                        echo '<pre class="pre-item">';
                        print_r ($response);
                        echo '</pre>';

                        echo "<h4>Success! Your test item was listed!</h4>";
                        echo "<p>Go to the permalink to see how it's looking in our site.</p>";
                        echo '<a target="_blank" href="'.$response["body"]->permalink.'">'.$response["body"]->permalink.'</a><br />';

                    } else if($_GET['code']) {
                        echo '<p><a alt="Publish Item" class="btn" href="/?code='.$_GET['code'].'&publish_item=ok">Publish Item</a></p>';
                    } else {
                        echo '<p><a alt="Publish Item" class="btn disable" href="#">Publish Item</a> </p>';
                    }
                    ?>

                </div>

                <div class="col-md-6">
                    <h3>Get started!</h3>
                    <p>Now you know how easy it is to get information from our API. Check the rest of the examples on the SDK, and modify them as you like in order to List an item, update it, and other actions.</p>
                    <p><a class="btn" href="https://github.com/mercadolibre/php-sdk/tree/master/examples">More examples</a></p>
                </div>
            </div>
</body>
</html>