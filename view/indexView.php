<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja-JP">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Content-Style-Type" content="text/css">
        <meta http-equiv="content-script-type" content="text/javascript">
        <!--[if IE]><script type="text/javascript" src="js/excanvas.js"></script><![endif]-->
        <script type="text/javascript" src="js/draw.js"></script>
        <title>適当なお絵かき掲示板</title>
    </head>

    <body>
        <div id="header">
            <h1>適当なお絵かき掲示板</a></h1>
        </div>

        <div id="main">
            <h2><?php echo $hoge; ?></h2>
        </div>
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
    </body>
</html>