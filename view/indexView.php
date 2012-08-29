<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja-JP">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Content-Style-Type" content="text/css">
        <meta http-equiv="content-script-type" content="text/javascript">
        <link href="css/index.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="jquery-1.7.2.min.js"></script>
        <!--[if IE]><script type="text/javascript" src="js/excanvas.js"></script><![endif]-->
        <title>適当なお絵かき掲示板</title>
    </head>

    <body>
        <div id="all">
        <div id="header">
            <h1>適当なお絵かき掲示板</a></h1>
        </div>

        <div id="main">
            <div id="live">
                <div id="livewrite">
                    <img src="img/wait.png">
                </div>
                <div id="livefinish">
                    <canvas id="myCanvas" width="320" height="240">
                    </canvas>
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
            <p><h2><?php echo $this->escape($image['title']) . ' - ' .  $this->escape($image['name']); ?></h2></p>
            <table border="1" align="center">
            <tr>
                <td width="480px"><img src="<?php echo $image['imageurl']; ?>" border="1"></td>
                <td width="480px"><div id="comments"><ul>
                <?php foreach($image['comments'] as $comment): ?>
                    <li><?php echo $this->escape($comment['comment']) . ' - ' . $this->escape($comment['name']); ?></li>
                <?php endforeach; ?>
                </ul></div></td>
            </tr>
            </table>
                <div class="comment">
                    <div id ="<?php echo $image['id']; ?>">
<!--                    <form method="POST" action="index.php">-->
                        <input type="hidden" name="ticket" value="<?php echo $ticket; ?>">
                        <input type="hidden" name="threadid" value="<?php echo $image['id']; ?>">
                        名前：<input type="text" name="name">
                        コメント：<input type="text" name="comment">
                        <button type="button" name="commentSend" onclick="sendComment(<?php echo $image['id']; ?>, '<?php echo $ticket; ?>')">送信</button>
<!--                        <input type="submit" value="送信">-->
<!--                    </form>-->
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div id="next">
            <a href="index.php?number=<?php echo $number + 1; ?>">次へ</a>
        </div>

        <script src="http://tetsuone.rackbox.net:8080/socket.io/socket.io.js"></script>
        <script type="text/javascript">
            var canvas = document.getElementById('myCanvas');
            var ctx = canvas.getContext('2d');
            var img = new Image();
            img.src = "img/livewait.png";
            img.onload = function() {
                ctx.drawImage(img, 0, 0, 320, 240, 0, 0, 320, 240);
            }
            
            function pushSubmit() {
                document.getElementsByTagName('form')[0].submit();
            }
            var socket = io.connect('http://tetsuone.rackbox.net:8080');
            socket.on('draw', function (data) {
                if (data.pagenum == <?php echo $threadnum; ?>) {
                    var element = document.getElementById('livewrite');
                    element.innerHTML = '<img src="img/livewrite.png">';
                    element.addEventListener('click', pushSubmit, false);
                }
                if (data.act === 'move') {
                    ctx.clearRect(0, 0, 320, 240);
                    var img = new Image();
                    img.src = data.image;
                    img.onload = function() {
                        ctx.drawImage(img, 0, 0, 480, 320, 0, 0, 320, 240);
                    }
                    var element = document.getElementById('livewrite');
                    element.innerHTML = '<img src="img/wait.png">';
                }
            });
            function sendComment(threadid, ticket) {
                var ele = document.getElementById(threadid);
                var name = ele.getElementByName('name')[0];
                var comment = ele.getElementByName('comment')[0];
                $.ajax({
                    type: 'post',
                    url: 'comment.php',
                    data: {
                        threadid: threadid,
                        ticket: ticket,
                        name: name,
                        comment: comment
                    },
                    success: function(data){
                        document.getElementById(threadid).innerHTML = data;
                    }
                });
            }
        </script>
        </div>
    </body>
</html>