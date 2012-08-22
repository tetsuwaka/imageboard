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
            <div class="image">
            <p><h3><?php echo $this->escape($image['title']) . ' - ' .  $this->escape($image['name']); ?></h3></p>
            <table border="1">
            <tr>
                <td width="480px"><img src="<?php echo $image['imageurl']; ?>" border="1"></td>
                <td width="480px"><ul>
                <?php foreach($image['comments'] as $comment): ?>
                    <li><?php echo $this->escape($comment['comment']) . ' - ' . $this->escape($comment['name']); ?></li>
                <?php endforeach; ?>
                </ul></td>
            </tr>
            </table>
            <form method="POST" action="comment.php">
                名前：<input type="text" name="name">
                コメント：<input type="text" name="comment">
                <input type="submit" value="送信"> 
            </form>
            </div>
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