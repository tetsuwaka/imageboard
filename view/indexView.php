<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja-JP">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Content-Style-Type" content="text/css">
        <meta http-equiv="content-script-type" content="text/javascript">
        <!--[if IE]><script type="text/javascript" src="js/excanvas.js"></script><![endif]-->
        <title>適当なお絵かき掲示板</title>
    </head>

    <body>
        <div id="header">
            <h1>適当なお絵かき掲示板</a></h1>
        </div>

        <div id="main">
            <?php foreach($imagelist as $image): ?>
            <p><h3><?php echo $image['title'] . ' - ' . $image['name']; ?></h3></p>
            <table>
            <tr>
                <td><img src="<?php echo $image['imageurl']; ?>"><td>
                <td><ul>
                <?php foreach($image['comments'] as $comment): ?>
                    <li><?php echo $comment['comment'] . ' - ' . $comment['name']; ?></li>
                <?php endforeach; ?>
                </ul></td>
            </tr>
            </table>
            <?php endforeach; ?>
        </div>
        
        <script type="text/javascript">
            var socket = io.connect('http://tetsuone.rackbox.net:8080');
            socket.on('start', function (data) {
                if (data.pagenum) {
                    document.getElementById('nowprinting').innerHTML = "<a href='draw.php?" + data.pagenum + "'>参加</a>";
                }
            });
        </script>
    </body>
</html>