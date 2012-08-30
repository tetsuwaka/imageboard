<html lang="ja-JP">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Content-Style-Type" content="text/css">
        <meta http-equiv="content-script-type" content="text/javascript">
        <link href="css/draw.css" rel="stylesheet" type="text/css">
        <!--[if IE]><script type="text/javascript" src="js/excanvas.js"></script><![endif]-->
        <title>共同お絵かき掲示板</title>
    </head>
    <body>
        <div id="all">
        <div id="header">
            <h1>共同お絵かきキャンバス</h1>
        </div>

        <div id="canvas">
            <canvas id="myCanvas" width="480" height="320">
                HTML5　Canvasに対応したブラウザーを使用してください。
            </canvas>
            <canvas id="save" width="240" height="160">
                <script type="text/javascript">
                    var canvas = document.getElementById('save');
                    var ctx = canvas.getContext('2d');
                    var img = new Image();
                    img.src = "img/save2.png";
                    img.onload = function() {
                        ctx.drawImage(img, 0, 0, 240, 160, 0, 0, 240, 160);
                    }
                </script>
            </canvas>
        </div>

        <div id="colorTemplate">
            <table border=1 width=250 height=30>
                <tr>
                    <td bgcolor="red" onClick="IB.changeColor('255,0,0')"></td>
                    <td bgcolor="blue" onClick="IB.changeColor('0,0,255')"></td>
                    <td bgcolor="green" onClick="IB.changeColor('0,255,0')"></td>
                    <td bgcolor="yellow" onClick="IB.changeColor('255,255,0')"></td>
                    <td bgcolor="purple" onClick="IB.changeColor('255,0,255')"></td>
                    <td bgcolor="#00FFFF" onClick="IB.changeColor('0,255,255')"></td>
                    <td bgcolor="black" onClick="IB.changeColor('0,0,0')"></td>
                    <td bgcolor="white" onClick="IB.changeColor('255,255,255')"></td>
                    <td bgcolor="gray" onClick="IB.changeColor('192,192,192')"></td>
                </tr>
            </table>
        </div>

        <div id="lineWidth">
            <FORM>
                線の太さ :
                <SELECT name="lineWidth" onChange="IB.changeLineWidth()">
                    <OPTION value="1" selected>1</OPTION>
                    <OPTION value="2">2</OPTION>
                    <OPTION value="4">4</OPTION>
                    <OPTION value="8">8</OPTION>
                    <OPTION value="16">16</OPTION>
                    <OPTION value="16">32</OPTION>
                </SELECT>
            </FORM>
        </div>

        <div id="buttons">
            <button type="button" name="erase" onclick="IB.erase()">消去</button>
            <button type="button" name="save" onclick="IB.save()">セーブ</button>
        </div>

        <div id="form">
        <form method="POST" action="draw.php">
            <input type="hidden" name="ticket" value="<?php echo $ticket; ?>">
            <input type="hidden" name="image" value="null">
            <div id="input">
                <p>タイトル</p>
                <input type="text" name="title"> <br>
                <p>名前</p>
                <input type="text" name="name"> <br>
            </div>
            <input type="submit" value="投稿する" style="font-size: 18px;" onclick="IB.move()">
        </form>
        </div>

        <span id="notice"><p>セーブしてから投稿してください。</p></span>

        <div id="return">
            <a href="index.php">トップに戻る</a>
        </div>

        <script src="http://tetsuone.rackbox.net:8080/socket.io/socket.io.js"></script>
        <script type="text/javascript" src="http://tetsuone.rackbox.net/imageboard/js/draw.js"></script>
        </div>
    </body>
</html>
