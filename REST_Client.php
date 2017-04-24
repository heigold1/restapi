<html>
 <body>

<?php

error_reporting(E_ALL);

function curl_get_contents($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

if (isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "get_app") 
{
  $app_info = curl_get_contents('http://ec2-54-202-139-209.us-west-2.compute.amazonaws.com/restapi/api.php?action=get_app&id=' . $_GET["id"]);
  $app_info = json_decode($app_info, true);
  ?>
    <table>
      <tr>
        <td>App Name: </td><td> <?php echo $app_info["app_name"] ?></td>
      </tr>
      <tr>
        <td>Price: </td><td> <?php echo $app_info["app_price"] ?></td>
      </tr>
      <tr>
        <td>Version: </td><td> <?php echo $app_info["app_version"] ?></td>
      </tr>
    </table>
    <br />
    <a href="./REST_Client.php?action=get_app_list" alt="app list">Return to the app list</a>
  <?php
}
else // else take the app list
{
echo "<div style='font-family: arial; font-size: 18px; font-weight: bold'>Simple REST Application.  <br><br>

This application will call a REST api located on my web server at ec2-54-202-139-209.us-west-2.compute.amazonaws.com. 
 The API will return application information for one of the applications clicked on below.<br><br> 

Choose one of the following applications for a description:<br></div>";

  $app_list = curl_get_contents('http://ec2-54-202-139-209.us-west-2.compute.amazonaws.com/restapi/api.php?action=get_app_list');
  $app_list = json_decode($app_list, true);
  ?>
    <ul>
    <?php foreach ($app_list as $app): ?>
      <li>
        <a href=<?php echo "./REST_Client.php?action=get_app&id=" . $app["id"]  ?> alt=<?php echo "app" . $app["id"] ?>><?php echo $app["name"] ?></a>
    </li>
    <?php endforeach; ?>
    </ul>
  <?php
} ?>
 </body>
</html>