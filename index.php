<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="fabric.js"></script>
    <style>
        canvas {
            border: 1px solid black;
        }
    </style>
    <title>DEMO</title>
</head>
<body>
<input type="file" id="file">
<input type="color" value="blue" id="fill"/>
<input type="font-size" value="blue" id="fill"/>
<select id="font">
    <option>arial</option>
    <option>tahoma</option>
    <option>times new roman</option>
</select>
<br/>
<canvas id="canvas" width="750" height="550"></canvas>
<br/>
<script>
    var canvas = new fabric.Canvas('canvas', {
        backgroundImage: 'img_lights.jpg',

    });
    fabric.Image.fromURL('img_lights.jpg', function (oImg) {
        canvas.add(oImg);
    });
    document.getElementById('file').addEventListener("change", function (e) {
        var file = e.target.files[0];
        var reader = new FileReader();
        console.log("reader   " + reader);
        reader.onload = function (f) {
            var data = f.target.result;
            fabric.Image.fromURL(data, function (img) {
                var oImg = img.set({ width: 750, height: 500, angle: 0}).scale(0.9);
                canvas.add(oImg).renderAll();
                canvas.setActiveObject(oImg);
            });
        };
        reader.readAsDataURL(file);
    });

    $('#fill').change(function () {
        var obj = canvas.getActiveObject();

        if (obj) {
            obj.set("fill", this.value);
        }
        canvas.renderAll();
    });

    $('#font').change(function () {
        var obj = canvas.getActiveObject();

        if (obj) {
            obj.set("fontFamily", this.value);
        }

        canvas.renderAll();
    });

    function addText(e) {
        var oText = new fabric.IText('Tap and Type', {
            top:e.offsetY,
            cursorDuration:200,
            left:e.offsetX,
        });

        canvas.add(oText);
        oText.bringToFront();
        canvas.setActiveObject(oText);
        $('#fill, #font').trigger('change');
    }
    canvas.on('mouse:down', function(options) {
        if (options.target == null)
            addText(options.e);
    });
</script>

</body>
</html>