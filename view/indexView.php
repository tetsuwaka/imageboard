<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja-JP">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Content-Style-Type" content="text/css">
        <meta http-equiv="content-script-type" content="text/javascript">
        <link href="css/index.css" rel="stylesheet" type="text/css">
        <!--[if IE]><script type="text/javascript" src="js/excanvas.js"></script><![endif]-->
        <title>適当なお絵かき掲示板</title>
    </head>

    <body>
        <div id="header">
            <h1>適当なお絵かき掲示板</a></h1>
        </div>

        <div id="main">
            <div id="live">
                <div id="livewrite">
                    <img src="img/wait.png">
                </div>
                <div id="livefinish">
                    <img src="img/livewait.png">
                </div>
            </div>
            
            <div id="draw">
                <form method="POST" action="draw.php">
                <input type="hidden" name="ticket" value="<?php echo $ticket; ?>">
                <input type="submit" value="お絵かきをする" style="font-size: 24px;">
                </form>
            </div>

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
                <div class="comment">
                    <form method="POST" action="index.php">
                        <input type="hidden" name="ticket" value="<?php echo $ticket; ?>">
                        <input type="hidden" name="threadid" value="<?php echo $image['id']; ?>">
                        名前：<input type="text" name="name">
                        コメント：<input type="text" name="comment">
                        <input type="submit" value="送信">
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <script src="http://tetsuone.rackbox.net:8080/socket.io/socket.io.js"></script>
        <script type="text/javascript">
            function pushSubmit() {
                document.getElementsByTagName('form')[0].submit();
            }
            var socket = io.connect('http://tetsuone.rackbox.net:8080');
            socket.on('draw', function (data) {
                if (data.pagenum) {
                    var element = document.getElementById('livewrite');
                    element.innerHTML = '<img src="img/livewrite.png">';
                    element.addEventListener('click', pushSubmit(), false);
                }
            });
        </script>
    </body>
</html>