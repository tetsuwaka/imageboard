<html lang="ja-JP">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Content-Style-Type" content="text/css">
        <meta http-equiv="content-script-type" content="text/javascript">
        <link href="css/draw.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
        <!--[if IE]><script type="text/javascript" src="js/excanvas.js"></script><![endif]-->
        <title>Live Canvas</title>
    </head>
    <body>
        <div id="all">
        <div id="header">
            <h1>Live Canvas</h1>
        </div>

        <div id="wrapper">
        <div id="left">
            <canvas id="setting" width="100" height="100">

                HTML5　Canvasに対応したブラウザーを使用してください。
            </canvas>
        </div>
        
        <div id="center">
        <div id="canvas">
            <canvas id="myCanvas" width="480" height="320">
                HTML5　Canvasに対応したブラウザーを使用してください。
            </canvas>
        </div>

        <div id="colorTemplate">
            <table>
                <tr>
                    <td style="background-color: rgba(255, 0, 0, 1)" onClick="IB.changeColor('255,0,0,1')"></td>
                    <td style="background-color: rgba(0, 0, 255, 1)" onClick="IB.changeColor('0,0,255,1')"></td>
                    <td style="background-color: rgba(0, 255, 0, 1)" onClick="IB.changeColor('0,255,0,1')"></td>
                    <td style="background-color: rgba(255, 255, 0, 1)" onClick="IB.changeColor('255,255,0,1')"></td>
                    <td style="background-color: rgba(255, 0, 255, 1)" onClick="IB.changeColor('255,0,255,1')"></td>
                    <td style="background-color: rgba(0, 255, 255, 1)" onClick="IB.changeColor('0,255,255,1')"></td>
                    <td style="background-color: rgba(0, 0, 0, 1)" onClick="IB.changeColor('0,0,0,1')"></td>
                    <td style="background-color: rgba(255, 255, 255, 1)" onClick="IB.changeColor('255,255,255,1')"></td>
                    <td style="background-color: rgba(192, 192, 192, 1)" onClick="IB.changeColor('192,192,192,1')"></td>
                </tr>
            </table>
        </div>

        <div id="color">
            <p>色直指定 : <input type="text" name="r" id="r"><input type="text" name="g" id="g"><input type="text" name="b" id="b"><input type="text" name="a" id="a"></p>
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
                    <OPTION value="32">32</OPTION>
                </SELECT>
            </FORM>
        </div>

        <div id="buttons">
            <button type="button" name="erase" onclick="IB.erase()">消去</button>
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
            <input type="submit" value="投稿する" id="doSubmit" onclick="IB.move()">
        </form>
        </div>

        <div id="threadnum">
            Thread Number : <span id="pagenum"><?php echo $pagenum; ?></span>
        </div>

        <div id="return">
            <a href="index.php">トップに戻る</a>
        </div>

        </div>
        </div>

        <div id="right">
            <div id="chat">
                <div id="chatbody">
                    <ul id="chatline">
                    </ul>
                </div>
                <div id="chatform">
                    <p>名前:
                    <input type="text" name="hname" id="hname"></p>
                    <p>コメント:
                    <input type="text" name="comment" id="comment"></p>
                    <button id="inputchat" onclick="IB.sendChat()">入力</button>
                </div>
            </div>
        </div>

        <script src="http://tetsuone.rackbox.net:8080/socket.io/socket.io.js"></script>
        <script type="text/javascript" src="http://tetsuone.rackbox.net/imageboard/js/draw.js"></script>
        </div>
    </body>
</html>
