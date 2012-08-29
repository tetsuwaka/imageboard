<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja-JP">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Content-Style-Type" content="text/css">
        <meta http-equiv="content-script-type" content="text/javascript">
        <link href="css/index.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
        <!--[if IE]><script type="text/javascript" src="js/excanvas.js"></script><![endif]-->
        <title>共同お絵かき掲示板</title>
    </head>

    <body>
        <div id="all">
        <div id="header">
            <h1>共同お絵かき掲示板</a></h1>
        </div>

        <div id="main">
            <div id="live">
                <div id="livewrite">
                    <img src="img/wait2.png">
                </div>
                <div id="livefinish">
                    <canvas id="myCanvas" width="240" height="160">
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
            <table class="imagetable">
            <tr>
                <td width="480px"><img src="<?php echo $image['imageurl']; ?>"></td>
                <td width="480px"><div class="comments"><div id="comment-<?php echo $image['id']; ?>"><ul>
                <?php foreach($image['comments'] as $comment): ?>
                    <li><?php echo $this->escape($comment['comment']) . ' - ' . $this->escape($comment['name']); ?></li>
                <?php endforeach; ?>
                </ul></div></div></td>
            </tr>
            </table>
                <div class="comment">
                    <div id ="<?php echo $image['id']; ?>">
                    <form id="form-<?php echo $image['id']; ?>">
                        <input type="hidden" name="ticket" value="<?php echo $ticket; ?>">
                        <input type="hidden" name="threadid" value="<?php echo $image['id']; ?>">
                        名前：<input type="text" name="name">
                        コメント：<input type="text" name="comment">
                        <button type="button" name="commentSend" onclick="sendComment(<?php echo $image['id']; ?>, '<?php echo $ticket; ?>')">送信</button>
                    </form>
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
            img.src = "img/livewait2.png";
            img.onload = function() {
                ctx.drawImage(img, 0, 0, 240, 160, 0, 0, 240, 160);
            }
            
            function pushSubmit() {
                document.getElementsByTagName('form')[0].submit();
            }
            var socket = io.connect('http://tetsuone.rackbox.net:8080');
            socket.on('draw', function (data) {
                if (data.pagenum == <?php echo $threadnum; ?>) {
                    var element = document.getElementById('livewrite');
                    element.innerHTML = '<img src="img/livewrite2.png">';
                    element.addEventListener('click', pushSubmit, false);
                }
                if (data.act === 'move') {
                    ctx.clearRect(0, 0, 240, 160);
                    var img = new Image();
                    img.src = data.image;
                    img.onload = function() {
                        ctx.drawImage(img, 0, 0, 480, 320, 0, 0, 240, 160);
                    }
                    var element = document.getElementById('livewrite');
                    element.innerHTML = '<img src="img/wait2.png">';
                }
            });
            function sendComment(threadid, ticket) {
                var ele = document.getElementById(threadid);
                var name = ele.getElementsByTagName('input')[2].value;
                var comment = ele.getElementsByTagName('input')[3].value;
                document.getElementById('form-' + threadid).reset();
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
                        document.getElementById('comment-' + threadid).innerHTML = data;
                    }
                });
            }
        </script>
        </div>
    </body>
</html>