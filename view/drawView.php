<html lang="ja-JP">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Content-Style-Type" content="text/css">
        <meta http-equiv="content-script-type" content="text/javascript">
        <link href="css/draw.css" rel="stylesheet" type="text/css">
        <!--[if IE]><script type="text/javascript" src="js/excanvas.js"></script><![endif]-->
        <title>適当なお絵かき掲示板</title>
    </head>
    <body>
        <h1>お絵かきキャンバス</h1>

        <canvas id="myCanvas" width="480" height="320">
            HTML5　Canvasに対応したブラウザーを使用してください。
        </canvas>

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

        <div id="eraseButton">
            <button type="button" name="erase" onclick="IB.erase()">消去</button>
        </div>

        <div id="pagenum">
            <?php echo $pagenum; ?>
        </div>

        <form method="POST" action="draw.php">
            <input type="hidden" name="ticket" value="<?php echo $ticket; ?>">
            名前：<input type="text" name="name"> <br>
            <input type="submit" value="投稿する" style="font-size: 18px;">
        </form>

        <script src="http://tetsuone.rackbox.net:8080/socket.io/socket.io.js"></script>
        <script type="text/javascript" src="http://tetsuone.rackbox.net/imageboard/js/draw.js"></script>
    </body>
</html>
